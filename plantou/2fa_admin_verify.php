<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['2fa_admin_id'])) {
    header("Location: login.php");
    exit;
}

$error_message = '';
$success_message = '';

if (isset($_SESSION['2fa_error'])) {
    $error_message = $_SESSION['2fa_error'];
    unset($_SESSION['2fa_error']);
}

$stmt = $pdo->prepare("SELECT nome_completo, username, pergunta_secreta FROM usuarios WHERE id = ? AND is_admin = 1");
$stmt->execute([$_SESSION['2fa_admin_id']]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    header("Location: login.php");
    exit;
}

$admin_name = $admin['nome_completo'] ?: $admin['username'];
$secret_question = $admin['pergunta_secreta'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação 2FA - Plantou</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .verify-card {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        .verify-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .verify-header h1 {
            font-size: 24px;
            color: #1a1a1a;
            margin-bottom: 10px;
            font-family: 'Montserrat', sans-serif;
        }
        .verify-header p {
            color: #666;
            font-size: 14px;
        }
        .verify-icon {
            font-size: 48px;
            color: #4caf50;
            margin-bottom: 15px;
        }
        .admin-badge {
            display: inline-block;
            background: #ff6b35;
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 12px;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .question-box {
            background: linear-gradient(135deg, #fff5f2 0%, #ffeee8 100%);
            border: 2px solid #ff6b35;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .question-box .question-label {
            font-size: 12px;
            color: #e65100;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .question-box .question-text {
            font-size: 18px;
            color: #bf360c;
            font-weight: 600;
            line-height: 1.4;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
            letter-spacing: 2px;
            text-align: center;
            font-weight: 600;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 15px rgba(255, 107, 53, 0.3);
            background: #fff8f5;
        }
        .btn-verify {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-verify:hover {
            background: linear-gradient(135deg, #f7931e 0%, #e8871c 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
        }

        .btn-verify:active {
            transform: translateY(0);
        }
        .message {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }
        .success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }
        .info-box {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border: 1px solid #ffb74d;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 13px;
            color: #e65100;
            line-height: 1.6;
        }
        
        .info-box strong {
            color: #bf360c;
        }
        .loading {
            display: none;
            text-align: center;
            color: #4caf50;
        }
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4caf50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @media (max-width: 480px) {
            .verify-card {
                padding: 30px 20px;
            }
            .verify-header h1 {
                font-size: 20px;
            }
            .verify-icon {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verify-card">
            <div class="verify-header">
                <div class="admin-badge">
                    <i class="fas fa-crown"></i> ADMINISTRADOR
                </div>
                <div class="verify-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h1>Verificação 2FA Admin</h1>
                <p>Responda sua pergunta secreta de administrador</p>
            </div>

            <?php if ($error_message): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="message success">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                </div>
                <div class="loading" style="display: block;">
                    <div class="spinner"></div>
                    Redirecionando para o painel administrativo...
                </div>
            <?php else: ?>

                <div class="question-box">
                    <div class="question-label">Pergunta Secreta do Admin:</div>
                    <div class="question-text"><?php echo htmlspecialchars($secret_question); ?></div>
                </div>

                <form method="POST" action="includes/2fa_admin_process.php">
                    <div class="form-group">
                        <label for="secret_answer">
                            <i class="fas fa-key"></i> Digite sua resposta:
                        </label>
                        <input 
                            type="text" 
                            id="secret_answer" 
                            name="secret_answer" 
                            placeholder="Digite a resposta secreta" 
                            required
                            autofocus
                            autocomplete="off"
                        >
                    </div>

                    <button type="submit" class="btn-verify">
                        <i class="fas fa-shield-alt"></i> Verificar Acesso Admin
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
