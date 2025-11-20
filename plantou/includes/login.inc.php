<?php
require_once 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'] ?? $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($login) || empty($password)) {
        echo '<div class="erro">Preenc ha todos os campos.</div>';
        exit;
    }
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? OR email = ?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $nome_completo = $user['nome_completo'] ?? $login;
        $nome_partes = explode(' ', $nome_completo);
        $primeiro_nome = $nome_partes[0];
        $_SESSION['temp_user_id'] = $user['id'];
        $_SESSION['temp_nome_usuario'] = $primeiro_nome;
        $_SESSION['temp_email'] = $user['email'];
        if ($user['is_admin']) {
            $_SESSION['2fa_admin_id'] = $user['id'];
            $_SESSION['is_admin_temp'] = 1;
            header("Location: ../2fa_admin_verify.php");
            exit;
        } else {
            $_SESSION['2fa_user_id'] = $user['id'];
            $_SESSION['is_admin_temp'] = 0;
            header("Location: ../2fa_user_verify.php");
            exit;
        }
    } else {
        echo '<div class="erro">Usuário ou senha inválidos!</div>';
    }
}
?>
