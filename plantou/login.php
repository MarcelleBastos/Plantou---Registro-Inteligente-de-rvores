<?php 
session_start();
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Plantou!</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a3a2a 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }
    .login-container {
      max-width: 500px;
      width: 100%;
    }
    .login-card {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(26, 58, 42, 0.5) 100%);
      border: 2px solid #2d5a4a;
      border-radius: 15px;
      padding: 50px 40px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5), 0 0 20px rgba(76, 175, 80, 0.1);
      animation: slideIn 0.6s ease-out;
    }
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .login-card h2 {
      font-size: 32px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 10px;
      text-align: center;
      font-family: 'Montserrat', sans-serif;
    }
    .login-card p {
      text-align: center;
      color: #a0a0a0;
      margin-bottom: 30px;
      font-size: 14px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      color: #c0c0c0;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .form-group input {
      width: 100%;
      padding: 12px 15px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid #2d5a4a;
      border-radius: 8px;
      color: #fff;
      font-size: 14px;
      transition: all 0.3s ease;
      font-family: 'Open Sans', sans-serif;
    }
    .form-group input::placeholder {
      color: #666;
    }
    .form-group input:focus {
      outline: none;
      background: rgba(76, 175, 80, 0.1);
      border-color: #4caf50;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.2);
    }
    .login-card button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 700;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 10px;
    }
    .login-card button:hover {
      box-shadow: 0 0 20px rgba(76, 175, 80, 0.4);
      transform: translateY(-2px);
    }
    .login-links {
      text-align: center;
      margin-top: 25px;
      padding-top: 25px;
      border-top: 1px solid rgba(76, 175, 80, 0.2);
    }
    .login-links a {
      color: #4caf50;
      text-decoration: none;
      font-weight: 600;
      font-size: 13px;
      transition: all 0.3s ease;
      margin: 0 8px;
    }
    .login-links a:hover {
      color: #66bb6a;
      text-decoration: underline;
    }
    .success-message {
      background: rgba(76, 175, 80, 0.15);
      border-left: 4px solid #4caf50;
      border-radius: 4px;
      padding: 12px 15px;
      margin-bottom: 20px;
      color: #66bb6a;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .success-message i {
      color: #4caf50;
    }
    @media (max-width: 600px) {
      .login-card {
        padding: 40px 25px;
      }
      .login-card h2 {
        font-size: 24px;
      }
    }
  </style>
  <script>
    window.addEventListener('load', function() {
      fetch('includes/check_session.php')
        .then(r => r.text())
        .then(status => {
          if (status.trim() === 'logado') {
            window.location.href = 'dashboard.php';
          } else if (status.trim() === 'admin') {
            window.location.href = 'admin.php';
          }
        });
    });
  </script>
</head>
<body>
  <?php require_once 'includes/header.php'; ?>
  <main>
    <div class="login-container">
      <div class="login-card">
        <h2>🌱 Bem-vindo</h2>
        <p>Faça login na sua conta Plantou!</p>
        <?php 
        if (isset($_GET['success']) && $_GET['success'] === 'password_reset'): 
        ?>
          <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <span>Senha redefinida com sucesso! Agora você pode fazer login com sua nova senha.</span>
          </div>
        <?php endif; ?>
        <form action="includes/login.inc.php" method="post">
          <div class="form-group">
            <label for="login"><i class="fas fa-envelope"></i> E-mail ou Username</label>
            <input type="text" id="login" name="login" placeholder="Digite seu e-mail ou username" required>
          </div>
          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Senha</label>
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
          </div>
          <button type="submit">
            <i class="fas fa-sign-in-alt"></i> Entrar
          </button>
        </form>
        <div class="login-links">
          <a href="forgot-password.php"><i class="fas fa-key"></i> Esqueci a senha</a>
          <span>|</span>
          <a href="register.php"><i class="fas fa-user-plus"></i> Criar conta</a>
        </div>
      </div>
    </div>
  </main>
  <?php require_once 'includes/footer.php'; ?>
</body>
</html>
