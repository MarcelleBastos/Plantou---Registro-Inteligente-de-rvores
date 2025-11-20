<?php 
session_start();
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Plantou!</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
    require_once 'includes/header.php';
    ?>
    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <h1>Entre em Contato</h1>
            <p>Dúvidas, sugestões ou parcerias? Estamos aqui para conversar</p>
        </div>
    </section>
    <!-- Contact Information -->
    <section class="content-section">
        <div class="container">
            <h2>Canais de Contato</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <h4>E-mail</h4>
                    <p><a href="mailto:contato@plantou.com.br" style="color: var(--accent-orange); text-decoration: none;">contato@plantou.com.br</a></p>
                    <p>Respondemos em até 24 horas</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <h4>Telefone</h4>
                    <p><a href="tel:+5511999999999" style="color: var(--accent-orange); text-decoration: none;">+55 (11) 9 9999-9999</a></p>
                    <p>Segunda à Sexta, 9h às 18h</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <h4>Endereço</h4>
                    <p>Av. Paulista, 1000 - 12º andar<br>São Paulo, SP 01311-100</p>
                    <p>Visite nosso escritório</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-comments"></i>
                    <h4>Chat ao Vivo</h4>
                    <p>Disponível das 9h às 20h todos os dias</p>
                    <p><a href="#" style="color: var(--accent-orange); text-decoration: none;">Iniciar conversa</a></p>
                </div>
            </div>
            <h2 style="margin-top: 60px;">Formulário de Contato</h2>
            <form class="contact-form" id="contact-form">
                <div class="form-group">
                    <label for="name">Nome Completo *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="subject">Assunto *</label>
                    <select id="subject" name="subject" required>
                        <option selected>Selecione um assunto</option>
                        <option>Dúvida sobre doação</option>
                        <option>Problema técnico</option>
                        <option>Sugestão de melhoria</option>
                        <option>Parceria</option>
                        <option>Imprensa</option>
                        <option>Outro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Mensagem *</label>
                    <textarea id="message" name="message" rows="6" placeholder="Escreva sua mensagem..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">Enviar Mensagem</button>
            </form>
            <h2 style="margin-top: 60px;">Perguntas Frequentes</h2>
            <div style="margin: 40px 0;">
                <h3>Como faço para reportar um problema?</h3>
                <p>
                    Se encontrar algum problema técnico na plataforma, entre em contato conosco via e-mail ou chat. 
                    Nossa equipe técnica investigará e fornecerá suporte completo.
                </p>
            </div>
            <div style="margin: 40px 0;">
                <h3>Vocês aceitam parcerias?</h3>
                <p>
                    Sim! Estamos sempre abertos para parcerias estratégicas com empresas, ONGs e instituições que 
                    compartilhem de nossa missão ambiental. Envie uma mensagem descrevendo seu interesse.
                </p>
            </div>
            <div style="margin: 40px 0;">
                <h3>Posso criar um fundraiser?</h3>
                <p>
                    Absolutamente! Você pode organizar campanhas de arrecadação para o Plantou!. Entre em contato 
                    para conhecer nossos programas de fundraising e receber suporte especializado.
                </p>
            </div>
            <div style="margin: 40px 0;">
                <h3>Quais são os horários de atendimento?</h3>
                <p>
                    Respondemos e-mails e mensagens de segunda a sexta, das 9h às 18h (horário de Brasília). 
                    Chat ao vivo funciona de segunda a domingo, das 9h às 20h.
                </p>
            </div>
            <h2 style="margin-top: 60px;">Siga-nos nas Redes Sociais</h2>
            <div style="display: flex; gap: 20px; justify-content: center; margin: 40px 0; flex-wrap: wrap;">
                <a href="https://facebook.com/plantou" style="display: inline-block;">
                    <button class="btn btn-outline" style="width: auto; border-color: var(--accent-orange); color: var(--accent-orange);">
                        <i class="fab fa-facebook" style="margin-right: 8px;"></i>Facebook
                    </button>
                </a>
                <a href="https://instagram.com/plantou" style="display: inline-block;">
                    <button class="btn btn-outline" style="width: auto; border-color: var(--accent-orange); color: var(--accent-orange);">
                        <i class="fab fa-instagram" style="margin-right: 8px;"></i>Instagram
                    </button>
                </a>
                <a href="https://twitter.com/plantou" style="display: inline-block;">
                    <button class="btn btn-outline" style="width: auto; border-color: var(--accent-orange); color: var(--accent-orange);">
                        <i class="fab fa-twitter" style="margin-right: 8px;"></i>Twitter
                    </button>
                </a>
                <a href="https://youtube.com/plantou" style="display: inline-block;">
                    <button class="btn btn-outline" style="width: auto; border-color: var(--accent-orange); color: var(--accent-orange);">
                        <i class="fab fa-youtube" style="margin-right: 8px;"></i>YouTube
                    </button>
                </a>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="container foot-min">
            <a class="brand-min" href="#" aria-label="Página inicial">
                <span aria-hidden="true">🌱</span><strong>Plantou!</strong>
            </a>
            <nav class="foot-nav" aria-label="Rodapé">
                <a href="como-funciona.php">Como funciona</a>
                <a href="projetos.php">Projetos</a>
                <a href="contato.php">Contato</a>
                <a href="sobre.php">Sobre</a>
            </nav>
            <div class="foot-meta">
                <span>© <span id="year"></span> Plantou!</span>
                <a href="login.php" class="link-min">Entrar</a>
                <button class="top-link" type="button" aria-label="Voltar ao topo">↑</button>
            </div>
        </div>
        <script>
            document.getElementById('year').textContent = new Date().getFullYear();
            document.querySelector('.top-link')?.addEventListener('click', () =>
                window.scrollTo({ top: 0, behavior: 'smooth' })
            );
            document.getElementById('contact-form').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');
                this.reset();
            });
        </script>
    </footer>
</body>
</html>
