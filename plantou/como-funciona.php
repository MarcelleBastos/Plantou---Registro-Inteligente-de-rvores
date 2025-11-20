<?php 
session_start();
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Como Funciona - Plantou!</title>
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
            <h1>Como Funciona</h1>
            <p>Entenda cada passo do processo de reflorestamento</p>
        </div>
    </section>
    <!-- Steps Section -->
    <section class="content-section">
        <div class="container">
            <h2>Seu Caminho para o Impacto</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <i class="fas fa-user-plus"></i>
                    <h4>1. Registre-se</h4>
                    <p>Crie sua conta no Plantou! em poucos segundos. Apenas um e-mail e uma senha necessários.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h4>2. Escolha uma Ação</h4>
                    <p>Doe uma quantia, voluntarie seu tempo ou adote uma árvore. Você escolhe como contribuir.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <h4>3. Confirme seu Compromisso</h4>
                    <p>Complete a transação de forma segura. Todas as doações são processadas com encriptação de dados.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-map-pin"></i>
                    <h4>4. Receba um QR Code</h4>
                    <p>Sua árvore recebe um QR Code único. Escaneie para acompanhar seu crescimento em tempo real.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-bar"></i>
                    <h4>5. Acompanhe o Impacto</h4>
                    <p>Veja métricas de CO² absorvido, biodiversidade restaurada e histórico de desenvolvimento.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-trophy"></i>
                    <h4>6. Ganhe Recompensas</h4>
                    <p>Desbloqueie moedas virtuais e badges à medida que sua contribuição cresce. Ação tem limite?</p>
                </div>
            </div>
            <h3>Sistema de Recompensas</h3>
            <p>
                Acreditamos em gamificar o impacto. Cada ação traz benefícios:
            </p>
            <div class="feature-grid">
                <div class="feature-item">
                    <i class="fas fa-coins"></i>
                    <h4>Moedas Plantou</h4>
                    <p>Acumule pontos a cada árvore. Troque por produtos ecológicos ou doações adicionais.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-star"></i>
                    <h4>Badges e Níveis</h4>
                    <p>Alcance novos níveis: Germinador, Semeador, Florestão! Cada nível desbloqueia benefícios.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-gift"></i>
                    <h4>Ofertas Especiais</h4>
                    <p>Parceiros oferecem descontos exclusivos para membros Plantou! que contribuem regularmente.</p>
                </div>
            </div>
            <h3>Tecnologia por Trás</h3>
            <p>
                <strong>PWA (Progressive Web App):</strong> Acesse Plantou! de qualquer dispositivo, inclusive offline.<br><br>
                <strong>QR Codes:</strong> Cada árvore tem um QR Code único para rastreamento e monitoramento.<br><br>
                <strong>IoT e Sensores:</strong> Monitoramos temperatura, umidade e saúde das árvores em tempo real.<br><br>
                <strong>Blockchain:</strong> Todas as transações são registradas para máxima transparência.
            </p>
            <h3>Perguntas Frequentes</h3>
            <p>
                <strong>Quanto custa plantar uma árvore?</strong><br>
                O valor mínimo é R$ 5,00. Quanto mais você doa, mais impacto você tem. Não há limite máximo!<br><br>
                <strong>Posso ver minha árvore crescer?</strong><br>
                Sim! Através do QR Code, você acessa fotos de satélite, métricas de crescimento e um histórico completo.<br><br>
                <strong>Minhas doações vão realmente para árvores?</strong><br>
                100% do valor da sua doação vai para reflorestamento. Nossa ONG é auditada anualmente por instituições independentes.<br><br>
                <strong>Posso cancelar meu compromisso?</strong><br>
                Sim, você pode cancelar sua adoção a qualquer momento. Ações já realizadas não podem ser revertidas.
            </p>
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
        </script>
    </footer>
</body>
</html>
