<?php 
session_start();
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantou! - Projeto Ecológico</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <?php 
    require_once 'includes/header.php';
    ?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Transforme doações em florestas!</h2>
            <p>Participe do Plantou! e acompanhe em tempo real o impacto das suas doações no reflorestamento de áreas
                degradadas.</p>
            <button class="btn btn-primary">Começar Agora</button>
        </div>
    </section>
    <!-- Rewards System -->
    <section class="rewards">
        <div class="container">
            <h2 class="section-title">Sistema de Recompensas</h2>
            <div class="rewards-container">
                <div class="reward-card">
                    <i class="fas fa-tree tree-icon"></i>
                    <h3>Suas Doações</h3>
                    <p>Acompanhe seu progresso para o próximo nível</p>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 65%;">65%</div>
                    </div>
                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-value">12</div>
                            <div class="stat-label">Árvores</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">5</div>
                            <div class="stat-label">Moedas</div>
                        </div>
                    </div>
                    <i class="fas fa-globe-americas tree-icon" style="margin-top: 20px;"></i>
                    <h3>Impacto Global</h3>
                    <p>Contribuição total da comunidade</p>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 80%;">80%</div>
                    </div>
                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-value">5,247</div>
                            <div class="stat-label">Árvores</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">12m</div>
                            <div class="stat-label">CO² reduzido</div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- Forms Section -->
    <section class="forms">
        <div class="container">
            <h2 class="section-title">Junte-se à Nossa Comunidade</h2>
            <div class="form-container">
                <div class="form-card">
                    <h3 class="form-title">Solicitar manutenção</h3>
                    <form class="form">
                        <div class="form-group">
                            <label for="tree-id">ID da árvore</label>
                            <input type="text" id="tree-id" placeholder="#BR-01877">
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo de solicitação</label>
                            <select id="tipo">
                                <option selected>Selecione</option>
                                <option>Poda</option>
                                <option>Irrigação</option>
                                <option>Praga/Doença</option>
                                <option>Risco/Queda</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea id="descricao" rows="3" placeholder="Descreva o problema observado..."></textarea>
                        </div>
                        <button class="btn btn-primary" type="button" aria-disabled="true" title="Protótipo sem envio"
                            style="width:100%;">Abrir chamado</button>
                        <p class="form-note">* Protótipo: chamado será registrado em relatórios no backend.</p>
                    </form>
                    <div class="tips" style="margin-top:18px;">
                        <h4 style="margin-bottom:6px;">Como funciona o QR Code?</h4>
                        <p>Ao escanear a placa da árvore, a PWA abre detalhes e permite registrar solicitações e adoção.
                        </p>
                        <ul class="list">
                            <li>Rápido e sem app na loja (PWA).</li>
                            <li>Funciona offline com sincronização posterior.</li>
                            <li>Transparência com histórico público.</li>
                        </ul>
                    </div>
                </div>
                <div class="form-card">
                    <h3 class="form-title">Doação</h3>
                    <form id="donation-form">
                        <div class="form-group">
                            <label for="donation-amount">Valor da Doação (R$)</label>
                            <input type="number" id="donation-amount" placeholder="Digite o valor" min="5" step="5">
                        </div>
                        <div class="form-group">
                            <label for="donation-name">Nome completo</label>
                            <input type="text" id="donation-name" placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="card-number">Número do Cartão</label>
                            <input type="text" id="card-number" placeholder="0000 0000 0000 0000">
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <div class="form-group" style="flex: 1;">
                                <label for="expiry-date">Validade</label>
                                <input type="text" id="expiry-date" placeholder="MM/AA">
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" placeholder="000">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Doar Agora</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer minimalista -->
    <footer class="site-footer" role="contentinfo">
        <div class="container foot-min">
            <a class="brand-min" href="#" aria-label="Página inicial">
                <span aria-hidden="true">🌱</span><strong>Plantou!</strong>
            </a>
            <nav class="foot-nav" aria-label="Rodapé">
                <a href="#como-funciona">Como funciona</a>
                <a href="#mapa">Mapa</a>
                <a href="#adocao">Adoção</a>
                <a href="#manutencao">Manutenção</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('register-form').addEventListener('submit', function (e) {
                e.preventDefault();
                alert('Conta criada com sucesso! Em breve você receberá um e-mail de confirmação.');
                this.reset();
            });
            document.getElementById('donation-form').addEventListener('submit', function (e) {
                e.preventDefault();
                const amount = document.getElementById('donation-amount').value;
                alert(`Obrigado pela sua doação de R$ ${amount}! Sua contribuição ajudará a plantar mais árvores.`);
                this.reset();
            });
            setInterval(() => {
                const coinsElement = document.querySelector('.reward-card .stat-value:nth-child(2)');
                let coins = parseInt(coinsElement.textContent);
                coins = (coins % 10) + 1;
                coinsElement.textContent = coins;
            }, 5000);
        });
    </script>
</body>
</html>
