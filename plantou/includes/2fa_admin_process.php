<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['2fa_admin_id'])) {
    header("Location: ../login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_SESSION['2fa_admin_id'];
    $submitted_answer = trim($_POST['secret_answer'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ? AND is_admin = 1");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch();
    if (!$admin) {
        session_destroy();
        header("Location: ../login.php");
        exit;
    }
    if (empty($admin['pergunta_secreta']) || empty($admin['resposta_secreta'])) {
        $_SESSION['setup_2fa_admin_id'] = $admin_id;
        header("Location: ../setup_2fa_admin.php");
        exit;
    }
    if (strtolower($submitted_answer) === strtolower($admin['resposta_secreta'])) {
        $nome_completo = $admin['nome_completo'] ?? $admin['username'];
        $nome_partes = explode(' ', $nome_completo);
        $primeiro_nome = $nome_partes[0];
        unset($_SESSION['2fa_admin_id']);
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['email'] = $admin['email'];
        $_SESSION['nome_usuario'] = $primeiro_nome;
        $_SESSION['is_admin'] = $admin['is_admin'];
        $_SESSION['is_admin_temp'] = null;
        
        header("Location: ../admin.php");
        exit;
    } else {
        $_SESSION['2fa_error'] = 'Resposta secreta incorreta! Tente novamente.';
        header("Location: ../2fa_admin_verify.php");
        exit;
    }
}
header("Location: ../2fa_admin_verify.php");
exit;
?>
