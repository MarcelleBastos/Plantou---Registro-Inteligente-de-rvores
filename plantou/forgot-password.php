<?php
session_start();
require_once 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['step'])) {
    unset($_SESSION['forgot_password_step']);
    unset($_SESSION['forgot_password_email']);
    unset($_SESSION['forgot_password_user_id']);
    unset($_SESSION['forgot_password_verified']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Plantou!</title>
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
        .password-recovery-container {
            max-width: 600px;
            width: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(26, 58, 42, 0.5) 100%);
            border: 2px solid #2d5a4a;
            border-radius: 15px;
            padding: 50px 40px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5), 0 0 20px rgba(76, 175, 80, 0.1);
            animation: slideIn 0.6s ease-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .password-recovery-container h2 {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
            text-align: center;
            font-family: "Montserrat", sans-serif;
        }
        .password-recovery-container > p {
            text-align: center;
            color: #a0a0a0;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .step-indicator {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .step-number {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(76, 175, 80, 0.1);
            color: #a0a0a0;
            font-weight: 600;
            border: 2px solid rgba(76, 175, 80, 0.2);
            transition: all 0.3s ease;
        }
        .step-number.active {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: #fff;
            border-color: #4caf50;
        }
        .step-number.completed {
            background: rgba(76, 175, 80, 0.3);
            color: #66bb6a;
            border-color: #4caf50;
        }
        .recovery-step {
            display: none;
        }
        .recovery-step.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #2d5a4a;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: "Open Sans", sans-serif;
        }
        .form-group input::placeholder {
            color: #666;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            background: rgba(76, 175, 80, 0.1);
            border-color: #4caf50;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.2);
        }
        .verification-options {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }
        .verification-option {
            flex: 1;
            padding: 12px;
            border: 2px solid #2d5a4a;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: #c0c0c0;
            cursor: pointer;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .verification-option:hover {
            border-color: #4caf50;
            background: rgba(76, 175, 80, 0.1);
            color: #66bb6a;
        }
        .verification-option.selected {
            border-color: #4caf50;
            background: rgba(76, 175, 80, 0.2);
            color: #66bb6a;
        }
        .form-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
        .form-buttons button, .form-buttons a {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: #fff;
        }
        .btn-primary:hover {
            box-shadow: 0 0 20px rgba(76, 175, 80, 0.4);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #c0c0c0;
            border: 1px solid #2d5a4a;
        }
        .btn-secondary:hover {
            background: rgba(76, 175, 80, 0.1);
            color: #66bb6a;
            border-color: #4caf50;
        }
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-error {
            background: rgba(198, 40, 40, 0.15);
            border-left: 4px solid #c62828;
            color: #ff6b6b;
        }
        .alert-success {
            background: rgba(76, 175, 80, 0.15);
            border-left: 4px solid #4caf50;
            color: #66bb6a;
        }
        .info-box {
            background: rgba(76, 175, 80, 0.1);
            border-left: 4px solid #4caf50;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 13px;
            color: #a0a0a0;
            line-height: 1.6;
        }
        .info-box strong {
            color: #66bb6a;
        }
        .password-criteria {
            margin-top: 15px;
            padding: 12px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            font-size: 12px;
        }
        .criteria-item {
            color: #a0a0a0;
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .criteria-item.valid {
            color: #66bb6a;
        }
        .criteria-item i {
            width: 16px;
            text-align: center;
        }
        @media (max-width: 600px) {
            .password-recovery-container {
                padding: 40px 25px;
            }
            .password-recovery-container h2 {
                font-size: 22px;
            }
            .form-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php require_once "includes/header.php"; ?>
    <main>
        <div class="password-recovery-container">
            <h2>🔑 Recuperar Senha</h2>
            <p>Siga os passos para redefinir sua senha</p>
                        <div class="step-indicator">
                <div class="step-number active" id="step1-indicator">1</div>
                <div class="step-number" id="step2-indicator">2</div>
                <div class="step-number" id="step3-indicator">3</div>
            </div>
            <?php if (isset($_GET["error"])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php
                    $errors = array(
                        "email_not_found" => "E-mail não encontrado em nosso sistema.",
                        "verification_failed" => "Dados de verificação incorretos. Tente novamente.",
                        "password_mismatch" => "As senhas não coincidem.",
                        "weak_password" => "Senha fraca. Use maiúsculas, minúsculas, números e caracteres especiais.",
                        "database_error" => "Erro ao atualizar a senha. Tente novamente."
                    );
                    $error = $_GET["error"];
                    echo isset($errors[$error]) ? $errors[$error] : "Ocorreu um erro. Tente novamente.";
                    ?></span>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET["success"]) && $_GET["success"] === "password_reset"): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Senha redefinida com sucesso! Redirecionando...</span>
                </div>
                <script>setTimeout(function() { window.location.href = "login.php"; }, 2000);</script>
            <?php endif; ?>
            <?php 
                $current_step = 1;
                if (isset($_GET['step'])) {
                    $current_step = intval($_GET['step']);
                } elseif (isset($_SESSION['forgot_password_step'])) {
                    $current_step = $_SESSION['forgot_password_step'];
                }
            ?>
            <div class="recovery-step <?php echo $current_step === 1 ? 'active' : ''; ?>" id="step1">
                <form method="POST" action="includes/forgot-password-process.php">
                    <input type="hidden" name="step" value="1">
                    <div class="form-group">
                        <label>E-mail Cadastrado</label>
                        <input type="email" name="email" placeholder="seu@email.com" required>
                    </div>
                    <div class="form-buttons">
                        <a href="login.php" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">Próximo</button>
                    </div>
                </form>
            </div>
            <div class="recovery-step <?php echo $current_step === 2 ? 'active' : ''; ?>" id="step2">
                <form method="POST" action="includes/forgot-password-process.php">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="email" value="<?php echo isset($_SESSION['forgot_password_email']) ? htmlspecialchars($_SESSION['forgot_password_email']) : ''; ?>">
                    <div class="form-group">
                        <label>Método de Verificação:</label>
                        <div class="verification-options">
                            <button type="button" class="verification-option selected" onclick="selectVerification(this, 'mae')">Mãe</button>
                            <button type="button" class="verification-option" onclick="selectVerification(this, 'cpf')">CPF</button>
                            <button type="button" class="verification-option" onclick="selectVerification(this, 'cep')">CEP</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="verification-label">Nome da Mãe</label>
                        <input type="text" id="verification-input" name="verification_data" placeholder="Digite" required>
                        <input type="hidden" id="verification_type" name="verification_type" value="mae">
                    </div>
                    <div class="form-buttons">
                        <button type="button" class="btn-secondary" onclick="goToStep(1)">Voltar</button>
                        <button type="submit" class="btn-primary">Verificar</button>
                    </div>
                </form>
            </div>
            <div class="recovery-step <?php echo $current_step === 3 ? 'active' : ''; ?>" id="step3">
                <form method="POST" action="includes/forgot-password-process.php">
                    <input type="hidden" name="step" value="3">
                    <input type="hidden" name="email" value="<?php echo isset($_SESSION['forgot_password_email']) ? htmlspecialchars($_SESSION['forgot_password_email']) : ''; ?>">
                    <div class="form-group">
                        <label>Nova Senha</label>
                        <input type="password" id="new-password" name="password" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    <div class="password-criteria" id="criteria">
                        <strong>Requisitos:</strong>
                        <div class="criteria-item" id="criteria-length"><i class="fas fa-circle"></i> 8 caracteres</div>
                        <div class="criteria-item" id="criteria-upper"><i class="fas fa-circle"></i> Maiúscula</div>
                        <div class="criteria-item" id="criteria-lower"><i class="fas fa-circle"></i> Minúscula</div>
                        <div class="criteria-item" id="criteria-number"><i class="fas fa-circle"></i> Número</div>
                        <div class="criteria-item" id="criteria-special"><i class="fas fa-circle"></i> Caractere especial</div>
                    </div>
                    <div class="form-group">
                        <label>Confirmar Senha</label>
                        <input type="password" id="confirm-password" name="password_confirm" placeholder="Repita a senha" required>
                    </div>
                    <div class="form-buttons">
                        <button type="button" class="btn-secondary" onclick="goToStep(2)">Voltar</button>
                        <button type="submit" class="btn-primary">Redefinir</button>
                    </div>
                </form>
            </div>
                        </div>
        </div>
    </main>
    <?php require_once "includes/footer.php"; ?>
        </div>
    </main>
    <?php require_once "includes/footer.php"; ?>
    <script>
        function goToStep(step) {
            document.querySelectorAll(".recovery-step").forEach(function(s) { s.classList.remove("active"); });
            document.getElementById("step" + step).classList.add("active");
            document.querySelectorAll(".step-number").forEach(function(el, i) {
                el.classList.remove("active", "completed");
                if (i + 1 < step) el.classList.add("completed");
                else if (i + 1 === step) el.classList.add("active");
            });
            window.scrollTo(0, 0);
        }
        function selectVerification(btn, type) {
            document.querySelectorAll(".verification-option").forEach(function(el) { el.classList.remove("selected"); });
            btn.classList.add("selected");
            var labels = {"mae": "Nome da Mãe", "cpf": "CPF (XXX.XXX.XXX-XX)", "cep": "CEP (XXXXX-XXX)"};
            var types = {"mae": "mae", "cpf": "cpf", "cep": "cep"};
            document.getElementById("verification-label").textContent = labels[type];
            document.getElementById("verification_type").value = types[type];
        }
        var currentStep = <?php echo $current_step; ?>;
        if (currentStep > 1) {
            goToStep(currentStep);
        }
        document.getElementById("new-password").addEventListener("input", function() {
            var pwd = this.value;
            var criteria = {
                "criteria-length": pwd.length >= 8,
                "criteria-upper": /[A-Z]/.test(pwd),
                "criteria-lower": /[a-z]/.test(pwd),
                "criteria-number": /[0-9]/.test(pwd),
                "criteria-special": /[!@#$%^&*]/.test(pwd)
            };
            for (var id in criteria) {
                var el = document.getElementById(id);
                if (criteria[id]) {
                    el.classList.add("valid");
                    el.querySelector("i").className = "fas fa-check-circle";
                } else {
                    el.classList.remove("valid");
                    el.querySelector("i").className = "fas fa-circle";
                }
            }
        });
    </script>
</body>
</html>
