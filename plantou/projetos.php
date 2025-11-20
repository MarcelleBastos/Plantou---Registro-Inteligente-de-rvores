<?php 
session_start();
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos - Plantou!</title>
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
            <h1>Nossos Projetos</h1>
            <p>Conheça as iniciativas de reflorestamento que estamos transformando</p>
        </div>
    </section>
    <!-- Projects Section -->
    <section class="content-section">
        <div class="container">
            <h2>Projetos em Andamento</h2>
            <div class="feature-grid">
                <div class="project-card">
                    <div class="project-image">
                        <i class="fas fa-tree"></i>
                    </div>
                    <div class="project-content">
                        <h3>Restauração da Mata Atlântica</h3>
                        <p>
                            Reflorestamento de uma área crítica de 500 hectares no Vale do Paraíba, São Paulo. 
                            Já plantamos 12.500 árvores nativas com suporte de pesquisadores locais.
                        </p>
                        <p><strong>Local:</strong> São Paulo, Brasil</p>
                        <p><strong>Progresso:</strong> 65% concluído</p>
                        <p><strong>Árvores:</strong> 12.500 / 20.000</p>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="project-content">
                        <h3>Reflorestamento do Cerrado</h3>
                        <p>
                            Iniciativa de restauração do Cerrado em Minas Gerais. Focamos em espécies nativas 
                            ameaçadas de extinção e que alimentam fauna local.
                        </p>
                        <p><strong>Local:</strong> Minas Gerais, Brasil</p>
                        <p><strong>Progresso:</strong> 42% concluído</p>
                        <p><strong>Árvores:</strong> 8.400 / 20.000</p>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <div class="project-content">
                        <h3>Revitalização da Floresta Amazônica</h3>
                        <p>
                            Proteção e reflorestamento de terras indígenas no Amazonas. Parceria direta com 
                            comunidades locais para máxima autenticidade e impacto.
                        </p>
                        <p><strong>Local:</strong> Amazonas, Brasil</p>
                        <p><strong>Progresso:</strong> 28% concluído</p>
                        <p><strong>Árvores:</strong> 5.600 / 20.000</p>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image">
                        <i class="fas fa-water"></i>
                    </div>
                    <div class="project-content">
                        <h3>Proteção de Mata de Galeria</h3>
                        <p>
                            Restauração das matas ciliares que protegem recursos hídricos no Distrito Federal. 
                            Espécies adaptadas para preservação de água doce.
                        </p>
                        <p><strong>Local:</strong> Distrito Federal, Brasil</p>
                        <p><strong>Progresso:</strong> 71% concluído</p>
                        <p><strong>Árvores:</strong> 14.200 / 20.000</p>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image">
                        <i class="fas fa-wind"></i>
                    </div>
                    <div class="project-content">
                        <h3>Reflorestamento de Caatinga</h3>
                        <p>
                            Revitalização do Bioma Caatinga no Sertão Nordestino. Espécies resistentes à seca 
                            e que fomentam economia local sustentável.
                        </p>
                        <p><strong>Local:</strong> Ceará, Brasil</p>
                        <p><strong>Progresso:</strong> 38% concluído</p>
                        <p><strong>Árvores:</strong> 7.600 / 20.000</p>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="project-content">
                        <h3>Mobilização Global</h3>
                        <p>
                            Expansão internacional em parceria com organizações não-governamentais globais. 
                            Planejamos alcançar América Latina, África e Ásia em 2025.
                        </p>
                        <p><strong>Local:</strong> Internacional</p>
                        <p><strong>Progresso:</strong> 15% concluído</p>
                        <p><strong>Árvores:</strong> 3.000 / 20.000</p>
                    </div>
                </div>
            </div>
            <h2 style="margin-top: 60px;">Estatísticas Gerais</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <i class="fas fa-tree"></i>
                    <h4>Total de Árvores</h4>
                    <p><strong style="color: var(--accent-orange); font-size: 1.5rem;">51.300</strong> árvores plantadas</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-cloud"></i>
                    <h4>CO² Absorvido</h4>
                    <p><strong style="color: var(--accent-orange); font-size: 1.5rem;">513 toneladas</strong> de CO² por ano</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-map"></i>
                    <h4>Área Restaurada</h4>
                    <p><strong style="color: var(--accent-orange); font-size: 1.5rem;">512 hectares</strong> de habitat natural</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <h4>Comunidade</h4>
                    <p><strong style="color: var(--accent-orange); font-size: 1.5rem;">8.500+</strong> doadores ativos</p>
                </div>
            </div>
            <h3 style="margin-top: 50px;">Participe</h3>
            <p>
                Quer fazer parte de um desses projetos? Escolha uma iniciativa que toque seu coração e 
                comece a fazer diferença hoje mesmo. Sua doação ajudará a restaurar biomas críticos e 
                proteger a biodiversidade do nosso planeta.
            </p>
            <p style="text-align: center; margin-top: 30px;">
                <a href="index.php"><button class="btn btn-primary" style="margin-top: 20px;">Começar Agora</button></a>
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
