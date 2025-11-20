<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['2fa_user_id'])) {
    header("Location: ../login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['2fa_user_id'];
    $submitted_answer = trim($_POST['secret_answer'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ? AND is_admin = 0");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if (!$user) {
        session_destroy();
        header("Location: ../login.php");
        exit;
    }
    if (empty($user['pergunta_secreta']) || empty($user['resposta_secreta'])) {
        $_SESSION['setup_2fa_user_id'] = $user_id;
        header("Location: ../setup_2fa.php");
        exit;
    }
    if (strtolower($submitted_answer) === strtolower($user['resposta_secreta'])) {
        $nome_completo = $user['nome_completo'] ?? $user['username'];
        $nome_partes = explode(' ', $nome_completo);
        $primeiro_nome = $nome_partes[0];
        unset($_SESSION['2fa_user_id']);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nome_usuario'] = $primeiro_nome;
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['is_admin_temp'] = null;
        
        header("Location: ../dashboard.php");
        exit;
    } else {
        $_SESSION['2fa_error'] = 'Resposta secreta incorreta! Tente novamente.';
        header("Location: ../2fa_user_verify.php");
        exit;
    }
}
header("Location: ../2fa_user_verify.php");
exit;
?>
