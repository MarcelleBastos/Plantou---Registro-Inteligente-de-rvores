<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$usuario_logado = isset($_SESSION['user_id']);
$nome_usuario = $_SESSION['nome_usuario'] ?? 'Usuário';
$eh_admin = $_SESSION['is_admin'] ?? false;
?>
<style>
    header {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        border-bottom: 3px solid #2d5a4a;
        padding: 0;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        gap: 30px;
        flex-wrap: nowrap;
    }
    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .logo i {
        font-size: 28px;
        color: #4caf50;
    }
    .logo h1 {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    nav {
        flex: 1;
        display: flex;
        justify-content: center;
    }
    nav ul {
        display: flex;
        list-style: none;
        gap: 0;
        margin: 0;
        padding: 0;
        flex-wrap: nowrap;
    }
    nav ul li {
        margin: 0;
    }
    nav ul li a {
        display: block;
        padding: 10px 18px;
        color: #b2dfdb;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
    }
    nav ul li a:hover {
        color: #4caf50;
        border-bottom-color: #4caf50;
    }
    .auth-buttons {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: nowrap;
        flex-shrink: 0;
    }
    .auth-buttons .user-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #b2dfdb;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        padding: 8px 12px;
        background: rgba(76, 175, 80, 0.1);
        border-radius: 6px;
        border-left: 3px solid #4caf50;
    }
    .auth-buttons .user-info i {
        color: #4caf50;
        font-size: 16px;
    }
    .auth-buttons .btn {
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        color: #fff;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
    }
    .btn-outline {
        background: transparent;
        color: #b2dfdb;
        border: 2px solid #4caf50;
    }
    .btn-outline:hover {
        background: rgba(76, 175, 80, 0.1);
        color: #4caf50;
    }
    .btn-secondary {
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
        border: 2px solid #4caf50;
    }
    .btn-secondary:hover {
        background: rgba(76, 175, 80, 0.3);
        color: #7dd66d;
        border-color: #7dd66d;
    }
    @media (max-width: 1024px) {
        .header-content {
            gap: 15px;
            padding: 12px 15px;
        }
        nav ul li a {
            padding: 8px 12px;
            font-size: 12px;
        }
        .logo h1 {
            font-size: 20px;
        }
    }
    @media (max-width: 768px) {
        .header-content {
            flex-wrap: wrap;
            gap: 12px;
            padding: 10px;
        }
        .logo h1 {
            display: none;
        }
        nav {
            order: 3;
            flex-basis: 100%;
        }
        nav ul {
            justify-content: space-around;
            gap: 0;
        }
        nav ul li a {
            padding: 8px 10px;
            font-size: 11px;
        }
        .auth-buttons {
            gap: 8px;
        }
        .auth-buttons .user-info {
            display: none;
        }
        .auth-buttons .btn {
            padding: 7px 12px;
            font-size: 11px;
        }
    }
</style>
<header>
    <div class="container header-content">
        <div class="logo">
            <i class="fas fa-seedling"></i>
            <h1>Plantou!</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="como-funciona.php">Como Funciona</a></li>
                <li><a href="projetos.php">Projetos</a></li>
                <li><a href="contato.php">Contato</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php if ($usuario_logado): ?>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($nome_usuario); ?></span>
                </div>
                <?php if ($eh_admin): ?>
                    <a href="admin.php" class="btn btn-secondary">Admin</a>
                <?php else: ?>
                    <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
                <?php endif; ?>
                <a href="includes/logout.php" class="btn btn-outline">Sair</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline">Entrar</a>
                <a href="register.php" class="btn btn-primary">Registrar</a>
            <?php endif; ?>
        </div>
    </div>
</header>
