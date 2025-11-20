<?php 
session_start();
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - Plantou!</title>
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
            <h1>Sobre o Plantou!</h1>
            <p>Transformando a floresta através da tecnologia e da comunidade</p>
        </div>
    </section>
    <!-- Missão e Visão -->
    <section class="content-section">
        <div class="container">
            <h2>Nossa Missão</h2>
            <p>
                Plantou! é um projeto que combina tecnologia e ação ambiental para restaurar florestas degradadas. 
                Nossa missão é democratizar o acesso ao reflorestamento, permitindo que qualquer pessoa contribua 
                para a recuperação do meio ambiente, independentemente de sua localização geográfica.
            </p>
            <h3>Por que Reflorestamento?</h3>
            <p>
                As florestas são os pulmões do nosso planeta. Elas absorvem CO², fornecem habitat para milhões 
                de espécies e regulam o ciclo da água. Porém, perdemos milhões de hectares de floresta a cada ano. 
                O Plantou! surge como uma resposta direta a essa crise climática.
            </p>
            <div class="feature-grid">
                <div class="feature-item">
                    <i class="fas fa-leaf"></i>
                    <h4>Sustentabilidade</h4>
                    <p>Práticas comprometidas com o meio ambiente e a regeneração dos ecossistemas florestais.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-handshake"></i>
                    <h4>Comunidade</h4>
                    <p>Conectamos doadores, voluntários e especialistas em um único ecossistema de impacto.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-line"></i>
                    <h4>Transparência</h4>
                    <p>Acompanhamento em tempo real de cada árvore plantada e seu impacto ambiental.</p>
                </div>
            </div>
            <h3>Nossa História</h3>
            <p>
                Nascido em 2024, Plantou! começou como uma ideia simples: criar um elo entre pessoas 
                que desejam fazer diferença e florestas que precisam ser recuperadas. Através de uma plataforma 
                web intuitiva e inovadora, transformamos a boa vontade em ações concretas. Cada doação é uma 
                árvore plantada. Cada árvore é um passo em direção a um futuro sustentável.
            </p>
            <h3>Nossos Valores</h3>
            <p>
                <strong>Integridade:</strong> Toda árvore plantada é monitorada e documentada. Cada doação é rastreada 
                com transparência total.<br><br>
                <strong>Inovação:</strong> Usamos tecnologia de ponta (PWA, QR Codes, IoT) para criar uma experiência 
                única de reflorestamento.<br><br>
                <strong>Inclusão:</strong> Acreditamos que qualquer pessoa pode contribuir para a mudança ambiental, 
                independentemente de sua situação financeira.
            </p>
        </div>
    </section>
    <!-- Team Section -->
    <section class="content-section" style="background: #f5f1ed;">
        <div class="container">
            <h2>Conheça Nosso Propósito</h2>
            <p>
                Plantou! não é apenas um projeto de reflorestamento. É um movimento que reconhece que cada indivíduo 
                tem o poder de criar mudança. Com cada árvore plantada, você não apenas contribui para a redução de CO², 
                mas também inspira outros a fazer o mesmo.
            </p>
            <p style="margin-top: 25px;">
                Nossa visão é criar um planeta onde a tecnologia e a natureza caminham juntas, onde cada pessoa 
                pode ver, rastrear e celebrar seu impacto ambiental em tempo real.
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
