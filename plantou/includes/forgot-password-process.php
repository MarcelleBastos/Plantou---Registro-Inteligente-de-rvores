<?php
session_start();
require_once 'db_connect.php';
function sanitize($data) {
    return trim(htmlspecialchars($data));
}
function validatePassword($password) {
    return $password;
}
function removeFormatting($value) {
    return $value;
}
function compareInsensitive($str1, $str2) {
    return strtolower(trim($str1)) === strtolower(trim($str2));
}
$step = $_POST['step'] ?? null;
try {
    if ($step === '1') {
        $email = sanitize($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../forgot-password.php?error=invalid_email");
            exit;
        }
        $stmt = $pdo->prepare("SELECT id, email FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            header("Location: ../forgot-password.php?error=email_not_found");
            exit;
        }
        $_SESSION['forgot_password_email'] = $email;
        $_SESSION['forgot_password_user_id'] = $user['id'];
        $_SESSION['forgot_password_step'] = 2;
        header("Location: ../forgot-password.php?step=2");
        exit;
    } elseif ($step === '2') {
        $email = sanitize($_POST['email'] ?? '');
        $verification_type = sanitize($_POST['verification_type'] ?? '');
        $verification_data = sanitize($_POST['verification_data'] ?? '');
        if (!isset($_SESSION['forgot_password_email']) || $_SESSION['forgot_password_email'] !== $email) {
            header("Location: ../forgot-password.php?error=session_expired");
            exit;
        }
        $user_id = $_SESSION['forgot_password_user_id'];
        $stmt = $pdo->prepare("SELECT id, nome_mae, cpf, cep FROM usuarios WHERE id = ? LIMIT 1");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            header("Location: ../forgot-password.php?error=user_not_found");
            exit;
        }
        $verification_success = false;
        switch ($verification_type) {
            case 'mae':
            case 'mother_name':
                if ($user['nome_mae'] && compareInsensitive($verification_data, $user['nome_mae'])) {
                    $verification_success = true;
                }
                break;
            case 'cpf':
                $user_cpf_clean = removeFormatting($user['cpf']);
                $input_cpf_clean = removeFormatting($verification_data);
                if ($user_cpf_clean && $user_cpf_clean === $input_cpf_clean) {
                    $verification_success = true;
                }
                break;
            case 'cep':
                $user_cep_clean = removeFormatting($user['cep']);
                $input_cep_clean = removeFormatting($verification_data);
                if ($user_cep_clean && $user_cep_clean === $input_cep_clean) {
                    $verification_success = true;
                }
                break;
        }
        if (!$verification_success) {
            header("Location: ../forgot-password.php?error=verification_failed");
            exit;
        }
        $_SESSION['forgot_password_verified'] = true;
        $_SESSION['forgot_password_step'] = 3;
        header("Location: ../forgot-password.php?step=3");
        exit;
    } elseif ($step === '3') {
        $email = sanitize($_POST['email'] ?? '');
        $new_password = $_POST['password'] ?? $_POST['new_password'] ?? '';
        $confirm_password = $_POST['password_confirm'] ?? $_POST['confirm_password'] ?? '';
        if (!isset($_SESSION['forgot_password_verified']) || !$_SESSION['forgot_password_verified']) {
            header("Location: ../forgot-password.php?error=verification_required");
            exit;
        }
        if (!isset($_SESSION['forgot_password_email']) || $_SESSION['forgot_password_email'] !== $email) {
            header("Location: ../forgot-password.php?error=email_mismatch");
            exit;
        }
        if (empty($new_password) || empty($confirm_password)) {
            header("Location: ../forgot-password.php?error=empty_password");
            exit;
        }
        if ($new_password !== $confirm_password) {
            header("Location: ../forgot-password.php?error=password_mismatch");
            exit;
        }
        if (!validatePassword($new_password)) {
            header("Location: ../forgot-password.php?error=weak_password");
            exit;
        }
        $user_id = $_SESSION['forgot_password_user_id'];
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
        try {
            $checkStmt = $pdo->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='usuarios' AND COLUMN_NAME='password_hash'");
            $checkStmt->execute();
            $columnExists = $checkStmt->rowCount() > 0;
            error_log("Verificando campo password_hash: " . ($columnExists ? "EXISTS" : "NOT EXISTS"));
            if (!$columnExists) {
                error_log("Adicionando coluna password_hash...");
                $pdo->exec("ALTER TABLE usuarios ADD COLUMN password_hash VARCHAR(255) DEFAULT ''");
            }
            $stmt = $pdo->prepare("UPDATE usuarios SET password_hash = ?, data_atualizacao = NOW() WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $pdo->errorInfo()[2]);
            }
            error_log("Executando UPDATE para user_id: $user_id com hash: " . substr($password_hash, 0, 20) . "...");
            $result = $stmt->execute([$password_hash, $user_id]);
            if (!$result) {
                throw new Exception("Erro ao executar update: " . json_encode($stmt->errorInfo()));
            }
            $rowCount = $stmt->rowCount();
            error_log("Linhas afetadas pelo UPDATE: $rowCount");
            if ($rowCount === 0) {
                $checkUserStmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
                $checkUserStmt->execute([$user_id]);
                $userExists = $checkUserStmt->rowCount() > 0;
                if (!$userExists) {
                    throw new Exception("Usuário com ID $user_id não encontrado no banco de dados");
                } else {
                    error_log("Usuário existe mas UPDATE retornou 0 linhas. Pode ser um erro no MySQL.");
                    $forceStmt = $pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE id = ?");
                    $forceResult = $forceStmt->execute([$password_hash, $user_id]);
                    error_log("Força UPDATE result: " . ($forceResult ? "OK" : "FAILED"));
                }
            }
        } catch (Exception $e) {
            error_log("ERRO CRÍTICO ao atualizar senha: " . $e->getMessage() . " | User ID: " . $user_id . " | Trace: " . $e->getTraceAsString());
            header("Location: ../forgot-password.php?error=database_error");
            exit;
        }
        unset($_SESSION['forgot_password_email']);
        unset($_SESSION['forgot_password_user_id']);
        unset($_SESSION['forgot_password_verified']);
        unset($_SESSION['forgot_password_step']);
        header("Location: ../login.php?success=password_reset");
        exit;
    } else {
        header("Location: ../forgot-password.php?error=invalid_step");
        exit;
    }
} catch (PDOException $e) {
    error_log("Erro em forgot-password-process.php: " . $e->getMessage());
    header("Location: ../forgot-password.php?error=database_error");
    exit;
}
?>
