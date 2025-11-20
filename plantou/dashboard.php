<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'includes/db_connect.php';
try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT * FROM doacoes WHERE user_id = ? ORDER BY data_doacao DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $doacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("
        SELECT a.* FROM arvores a
        INNER JOIN usuario_arvore ua ON a.id = ua.arvore_id
        WHERE ua.user_id = ?
        ORDER BY ua.data_adocao DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $arvores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao buscar dados do dashboard: " . $e->getMessage());
    $doacoes = [];
    $arvores = [];
}
$total_doado = array_sum(array_column($doacoes, 'valor_doacao'));
$total_arvores = count($arvores);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Plantou!</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    <section class="hero" style="background: var(--deep-wood); padding: 40px 0; text-align: center;">
        <div class="container">
            <h1 style="color: var(--cream-white); margin-bottom: 10px;">
                BEM-VINDO, <?php echo strtoupper(htmlspecialchars($_SESSION['nome_usuario'])); ?>!
            </h1>
            <p style="color: var(--light-soil); font-size: 1.1rem;">
                Você está logado no Plantou!
            </p>
        </div>
    </section>
    <section class="content" style="padding: 40px 0;">
        <div class="container">
            <!-- CARD ESTATÍSTICAS -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
                <div class="form-card" style="text-align: center; padding: 20px;">
                    <i class="fas fa-heart" style="font-size: 2rem; color: var(--error-red); margin-bottom: 10px;"></i>
                    <h3 style="color: var(--dark-forest); margin: 10px 0;">Total Doado</h3>
                    <p style="font-size: 1.5rem; color: var(--accent-orange); font-weight: bold;">R$ <?php echo number_format($total_doado, 2, ',', '.'); ?></p>
                </div>
                <div class="form-card" style="text-align: center; padding: 20px;">
                    <i class="fas fa-tree" style="font-size: 2rem; color: var(--moss-green); margin-bottom: 10px;"></i>
                    <h3 style="color: var(--dark-forest); margin: 10px 0;">Árvores Adotadas</h3>
                    <p style="font-size: 1.5rem; color: var(--accent-orange); font-weight: bold;"><?php echo $total_arvores; ?></p>
                </div>
                <div class="form-card" style="text-align: center; padding: 20px;">
                    <i class="fas fa-leaf" style="font-size: 2rem; color: var(--earthy-brown); margin-bottom: 10px;"></i>
                    <h3 style="color: var(--dark-forest); margin: 10px 0;">Total Doações</h3>
                    <p style="font-size: 1.5rem; color: var(--accent-orange); font-weight: bold;"><?php echo count($doacoes); ?></p>
                </div>
            </div>
            <!-- MINHAS DOAÇÕES -->
            <div style="margin-bottom: 40px;">
                <h2 class="section-title">MINHAS DOAÇÕES</h2>
                <?php if (count($doacoes) > 0): ?>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <thead>
                            <tr style="background: var(--dark-forest); color: var(--cream-white);">
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Data</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Valor</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doacoes as $doacao): ?>
                                <tr style="background: var(--cream-white); border: 3px solid var(--dark-forest);">
                                    <td style="padding: 12px;"><?php echo date('d/m/Y', strtotime($doacao['data_doacao'])); ?></td>
                                    <td style="padding: 12px;">R$ <?php echo number_format($doacao['valor_doacao'], 2, ',', '.'); ?></td>
                                    <td style="padding: 12px;">
                                        <span style="background: <?php echo ($doacao['status'] === 'confirmado') ? 'var(--moss-green)' : 'var(--stone-gray)'; ?>; color: var(--cream-white); padding: 5px 10px; border-radius: 0; border: 2px solid <?php echo ($doacao['status'] === 'confirmado') ? 'var(--moss-green)' : 'var(--stone-gray)'; ?>; font-weight: bold;">
                                            <?php echo strtoupper($doacao['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="form-card" style="text-align: center; padding: 30px;">
                        <p style="color: var(--stone-gray); font-size: 1rem;">Você ainda não fez nenhuma doação.</p>
                        <a href="como-funciona.php" class="btn btn-primary" style="margin-top: 15px; display: inline-block;">Conheça nossos projetos</a>
                    </div>
                <?php endif; ?>
            </div>
            <!-- MINHAS ÁRVORES ADOTADAS -->
            <div>
                <h2 class="section-title">ÁRVORES ADOTADAS</h2>
                <?php if (count($arvores) > 0): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
                        <?php foreach ($arvores as $arvore): ?>
                            <div class="form-card" style="padding: 20px;">
                                <h3 style="color: var(--dark-forest); margin-bottom: 10px; text-transform: uppercase;">
                                    <?php echo htmlspecialchars($arvore['nome']); ?>
                                </h3>
                                <p style="color: var(--stone-gray); margin: 8px 0;">
                                    <strong>Tipo:</strong> <?php echo htmlspecialchars($arvore['tipo']); ?>
                                </p>
                                <p style="color: var(--stone-gray); margin: 8px 0;">
                                    <strong>Plantada em:</strong> <?php echo date('d/m/Y', strtotime($arvore['data_plantio'])); ?>
                                </p>
                                <p style="color: var(--stone-gray); margin: 8px 0;">
                                    <strong>Local:</strong> <?php echo htmlspecialchars($arvore['local']); ?>
                                </p>
                                <p style="color: var(--stone-gray); margin: 8px 0;">
                                    <strong>CO₂ Absorvido:</strong> <?php echo number_format($arvore['co2_absorvido'], 2, ',', '.'); ?> kg
                                </p>
                                <p style="color: var(--moss-green); margin-top: 10px; font-weight: bold;">
                                    Status: <?php echo strtoupper($arvore['status']); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="form-card" style="text-align: center; padding: 30px;">
                        <p style="color: var(--stone-gray); font-size: 1rem;">Você ainda não adotou nenhuma árvore.</p>
                        <a href="projetos.php" class="btn btn-primary" style="margin-top: 15px; display: inline-block;">Ver projetos disponíveis</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <footer class="site-footer">
        <div class="container foot-min">
            <a class="brand-min" href="index.php">
                <span>🌱</span><strong>Plantou!</strong>
            </a>
            <div class="foot-meta">
                <span>© <span id="year"></span> Plantou!</span>
            </div>
        </div>
        <script>
            document.getElementById('year').textContent = new Date().getFullYear();
        </script>
    </footer>
</body>
</html>
