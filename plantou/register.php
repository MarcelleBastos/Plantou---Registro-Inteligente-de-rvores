<?php 
session_start();
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar - Plantou!</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
    .register-page {
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a3a2a 100%);
    }
    .register-container {
      max-width: 600px;
      margin: 60px auto;
      padding: 20px;
    }
    .register-card {
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
    .register-card h2 {
      font-size: 32px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 10px;
      text-align: center;
    }
    .register-subtitle {
      text-align: center;
      color: #b2dfdb;
      font-size: 14px;
      margin-bottom: 35px;
    }
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }
    .form-row.full {
      grid-template-columns: 1fr;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 0;
    }
    .form-group label {
      color: #b2dfdb;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .form-group input,
    .form-group select {
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid #2d5a4a;
      border-radius: 8px;
      padding: 12px 15px;
      color: #333;
      font-size: 14px;
      transition: all 0.3s ease;
      font-family: 'Open Sans', sans-serif;
    }
    .form-group input:focus,
    .form-group select:focus {
      background: rgba(255, 255, 255, 1);
      border-color: #4caf50;
      outline: none;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
    }
    .form-group input::placeholder {
      color: rgba(0, 0, 0, 0.5);
    }
    .form-group select option {
      background: #fff;
      color: #333;
      padding: 10px;
    }
    .form-group select option:hover,
    .form-group select option:selected {
      background: #4caf50;
      color: #fff;
    }
    .gender-group {
      display: flex;
      gap: 20px;
      margin-top: 8px;
    }
    .gender-group label {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 0;
      cursor: pointer;
      font-size: 14px;
      text-transform: none;
    }
    .gender-group input[type="radio"] {
      margin: 0;
      cursor: pointer;
      width: 18px;
      height: 18px;
      accent-color: #4caf50;
    }
    .erro {
      color: #ff6b6b;
      font-size: 12px;
      margin-top: 6px;
      display: none;
    }
    .erro.show {
      display: block;
    }
    .form-actions {
      display: flex;
      gap: 15px;
      margin-top: 35px;
    }
    .register-card button {
      flex: 1;
      padding: 13px 20px;
      background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .register-card button:hover {
      background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
    }
    .register-card button:active {
      transform: translateY(0);
    }
    .register-footer {
      text-align: center;
      margin-top: 25px;
      padding-top: 25px;
      border-top: 1px solid rgba(45, 90, 74, 0.5);
      color: #b2dfdb;
      font-size: 14px;
    }
    .register-footer a {
      color: #4caf50;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    .register-footer a:hover {
      color: #7dd66d;
    }
    .section-divider {
      margin: 30px 0;
      text-align: center;
      color: #666;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 2px;
      position: relative;
    }
    .section-divider::before,
    .section-divider::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 45%;
      height: 1px;
      background: rgba(76, 175, 80, 0.2);
    }
    .section-divider::before {
      left: 0;
    }
    .section-divider::after {
      right: 0;
    }
    .field-help {
      font-size: 12px;
      color: #999;
      margin-top: 6px;
    }
    #senha-criteria {
      background: rgba(76, 175, 80, 0.1);
      border: 1px solid rgba(76, 175, 80, 0.3);
      border-radius: 6px;
      padding: 12px;
      margin-top: 10px;
    }
    #senha-criteria p {
      margin: 0;
    }
    @media (max-width: 768px) {
      .register-card {
        padding: 30px 20px;
      }
      .register-card h2 {
        font-size: 24px;
      }
      .form-row {
        grid-template-columns: 1fr;
      }
      .form-actions {
        flex-direction: column;
      }
    }
  </style>
</head>
<body class="register-page">
  <?php 
  require_once 'includes/header.php';
  ?>
  <main class="register-container">
    <div class="register-card">
      <h2>🌱 Bem-vindo!</h2>
      <p class="register-subtitle">Crie sua conta e comece a plantar árvores</p>
      <form id="form" action="includes/register.inc.php" method="post">
        <!-- SEÇÃO 1: DADOS PESSOAIS -->
        <div class="section-divider">Dados Pessoais</div>
        <div class="form-row full">
          <div class="form-group">
            <label for="name"><i class="fas fa-user"></i> Nome Completo</label>
            <input type="text" id="name" name="name" placeholder="Digite seu nome completo" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="birth"><i class="fas fa-birthday-cake"></i> Data de Nascimento</label>
            <input type="date" id="birth" name="birth" required>
          </div>
          <div class="form-group">
            <label><i class="fas fa-venus-mars"></i> Gênero</label>
            <div class="gender-group">
              <label>
                <input type="radio" name="gender" value="masculino" required> Masculino
              </label>
              <label>
                <input type="radio" name="gender" value="feminino"> Feminino
              </label>
              <label>
                <input type="radio" name="gender" value="outro"> Outro
              </label>
            </div>
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label for="motherName"><i class="fas fa-female"></i> Nome da Mãe</label>
            <input type="text" id="motherName" name="motherName" placeholder="Digite o nome da sua mãe">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="secret_question"><i class="fas fa-question-circle"></i> Pergunta Secreta</label>
            <select id="secret_question" name="secret_question" required>
              <option value="">Selecione uma pergunta</option>
              <option value="Nome do seu primeiro animal de estimação?">Nome do seu primeiro animal de estimação?</option>
              <option value="Qual o nome da sua mãe?">Qual o nome da sua mãe?</option>
              <option value="Em que cidade você nasceu?">Em que cidade você nasceu?</option>
              <option value="Qual era o nome da sua primeira escola?">Qual era o nome da sua primeira escola?</option>
              <option value="Qual seu jogo favorito?">Qual seu jogo favorito?</option>
              <option value="Qual o nome do seu melhor amigo de infância?">Qual o nome do seu melhor amigo de infância?</option>
              <option value="Qual sua comida favorita?">Qual sua comida favorita?</option>
              <option value="Qual o nome da rua onde você cresceu?">Qual o nome da rua onde você cresceu?</option>
            </select>
          </div>
          <div class="form-group">
            <label for="secret_answer"><i class="fas fa-key"></i> Resposta Secreta</label>
            <input type="text" id="secret_answer" name="secret_answer" placeholder="Sua resposta" required>
            <p class="field-help">Esta resposta será usada para verificação de segurança</p>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="cpf"><i class="fas fa-id-card"></i> CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
            <div id="erroCpf" class="erro"></div>
          </div>
          <div class="form-group">
            <label for="phone"><i class="fas fa-mobile-alt"></i> Celular</label>
            <input type="text" id="phone" name="phone" placeholder="(11) 99999-9999">
            <div id="erroPhone" class="erro"></div>
          </div>
        </div>
        <!-- SEÇÃO 2: ENDEREÇO -->
        <div class="section-divider">Endereço</div>
        <div class="form-row">
          <div class="form-group">
            <label for="cep"><i class="fas fa-map-pin"></i> CEP</label>
            <input type="text" id="cep" name="cep" placeholder="00000-000">
          </div>
          <div class="form-group">
            <label for="uf"><i class="fas fa-flag"></i> UF</label>
            <input type="text" id="uf" name="uf" placeholder="SP" maxlength="2">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="city"><i class="fas fa-city"></i> Cidade</label>
            <input type="text" id="city" name="city" placeholder="São Paulo">
          </div>
          <div class="form-group">
            <label for="state"><i class="fas fa-map"></i> Estado</label>
            <input type="text" id="state" name="state" placeholder="São Paulo">
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label for="street"><i class="fas fa-road"></i> Rua</label>
            <input type="text" id="street" name="street" placeholder="Nome da rua">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="number"><i class="fas fa-home"></i> Número</label>
            <input type="text" id="number" name="number" placeholder="123">
          </div>
          <div class="form-group">
            <label for="neighboorhood"><i class="fas fa-landmark"></i> Bairro</label>
            <input type="text" id="neighboorhood" name="neighboorhood" placeholder="Bairro">
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label for="complement"><i class="fas fa-plus"></i> Complemento</label>
            <input type="text" id="complement" name="complement" placeholder="Apt 42, Apto 123 (opcional)">
            <p class="field-help">Deixe em branco se não houver complemento</p>
          </div>
        </div>
        <!-- SEÇÃO 3: AUTENTICAÇÃO -->
        <div class="section-divider">Autenticação</div>
        <div class="form-row full">
          <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> E-mail</label>
            <input type="email" id="email" name="email" placeholder="seu.email@example.com" required>
            <div id="erroEmail" class="erro"></div>
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Senha</label>
            <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
            <div id="senha-criteria"></div>
            <div id="erroSenha" class="erro"></div>
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label for="confirm-password"><i class="fas fa-lock"></i> Confirmar Senha</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Repita sua senha" required>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit"><i class="fas fa-user-plus"></i> Registrar</button>
        </div>
      </form>
      <div class="register-footer">
        Já tem conta? <a href="login.php">Entrar na plataforma</a>
      </div>
    </div>
  </main>
  <script src="js/cep.js"></script>
  <script src="js/validaRegister.js"></script>
  <footer>
    <div class="container footer-content-new">
      <div class="footer-main">
        <div class="footer-logo-desc">
          <div class="logo">
            <i class="fas fa-seedling"></i>
            <h1>Plantou!</h1>
          </div>
          <p class="footer-desc">Plante. Conecte. Transforme.<br>
            <span style="font-size:0.93em; color:#b2dfdb;">CNPJ: 12.345.678/0001-99<br>Email: contato@plantou.com<br>Rua Verde, 123 - São Paulo/SP</span>
          </p>
        </div>
        <div class="footer-links">
          <a href="#">Sobre</a>
          <a href="#">Projetos</a>
          <a href="#">Equipe</a>
          <a href="#">Contato</a>
          <a href="#">Política de Privacidade</a>
          <a href="#">Termos de Uso</a>
        </div>
        <div class="footer-social">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© 2023 Plantou! - Todos os direitos reservados</span>
      </div>
    </div>
  </footer>
</body>
</html>
