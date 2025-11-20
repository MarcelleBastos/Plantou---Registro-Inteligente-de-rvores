<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../admin.php");
    exit;
}
require_once 'db_connect.php';
$acao = $_GET['acao'] ?? $_POST['acao'] ?? null;
if (!$acao) {
    header("Location: ../admin.php");
    exit;
}
try {
    switch ($acao) {
        case 'create_doacao':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_id = $_POST['user_id'] ?? null;
                $valor_doacao = $_POST['valor_doacao'] ?? null;
                $status = $_POST['status'] ?? 'pendente';
                if (!$user_id || !$valor_doacao) {
                    throw new Exception("Campos obrigatórios faltando");
                }
                $stmt = $pdo->prepare("
                    INSERT INTO doacoes (user_id, valor_doacao, data_doacao, status)
                    VALUES (?, ?, NOW(), ?)
                ");
                $stmt->execute([$user_id, $valor_doacao, $status]);
                header("Location: ../admin.php?aba=doacoes&success=doacao_criada");
            }
            break;
        case 'update_doacao':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                $valor_doacao = $_POST['valor_doacao'] ?? null;
                $status = $_POST['status'] ?? null;
                if (!$id || !$valor_doacao || !$status) {
                    throw new Exception("Campos obrigatórios faltando");
                }
                $stmt = $pdo->prepare("
                    UPDATE doacoes 
                    SET valor_doacao = ?, status = ?
                    WHERE id = ?
                ");
                $stmt->execute([$valor_doacao, $status, $id]);
                header("Location: ../admin.php?aba=doacoes&success=doacao_atualizada");
            }
            break;
        case 'delete_doacao':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception("ID não fornecido");
            }
            $stmt = $pdo->prepare("DELETE FROM doacoes WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: ../admin.php?aba=doacoes&success=doacao_deletada");
            break;
        case 'create_arvore':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'] ?? null;
                $tipo = $_POST['tipo'] ?? null;
                $local = $_POST['local'] ?? null;
                $co2_absorvido = $_POST['co2_absorvido'] ?? null;
                $status = $_POST['status'] ?? 'plantada';
                if (!$nome || !$tipo || !$local || !$co2_absorvido) {
                    throw new Exception("Campos obrigatórios faltando");
                }
                $stmt = $pdo->prepare("
                    INSERT INTO arvores (nome, tipo, data_plantio, local, status, co2_absorvido)
                    VALUES (?, ?, NOW(), ?, ?, ?)
                ");
                $stmt->execute([$nome, $tipo, $local, $status, $co2_absorvido]);
                header("Location: ../admin.php?aba=arvores&success=arvore_criada");
            }
            break;
        case 'update_arvore':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                $nome = $_POST['nome'] ?? null;
                $tipo = $_POST['tipo'] ?? null;
                $local = $_POST['local'] ?? null;
                $co2_absorvido = $_POST['co2_absorvido'] ?? null;
                $status = $_POST['status'] ?? null;
                if (!$id || !$nome || !$tipo || !$local || !$co2_absorvido || !$status) {
                    throw new Exception("Campos obrigatórios faltando");
                }
                $stmt = $pdo->prepare("
                    UPDATE arvores 
                    SET nome = ?, tipo = ?, local = ?, co2_absorvido = ?, status = ?
                    WHERE id = ?
                ");
                $stmt->execute([$nome, $tipo, $local, $co2_absorvido, $status, $id]);
                header("Location: ../admin.php?aba=arvores&success=arvore_atualizada");
            }
            break;
        case 'delete_arvore':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception("ID não fornecido");
            }
            $stmt = $pdo->prepare("DELETE FROM usuario_arvore WHERE arvore_id = ?");
            $stmt->execute([$id]);
            $stmt = $pdo->prepare("DELETE FROM arvores WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: ../admin.php?aba=arvores&success=arvore_deletada");
            break;
        case 'create_projeto':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'] ?? null;
                $descricao = $_POST['descricao'] ?? null;
                $localizacao = $_POST['localizacao'] ?? null;
                $progresso_percentual = $_POST['progresso_percentual'] ?? 0;
                if (!$nome || !$descricao || !$localizacao) {
                    throw new Exception("Campos obrigatórios faltando");
                }
                $stmt = $pdo->prepare("
                    INSERT INTO projetos (nome, descricao, localizacao, progresso_percentual)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$nome, $descricao, $localizacao, $progresso_percentual]);
                header("Location: ../admin.php?aba=projetos&success=projeto_criado");
            }
            break;
        case 'update_projeto':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                $nome = $_POST['nome'] ?? null;
                $descricao = $_POST['descricao'] ?? null;
                $localizacao = $_POST['localizacao'] ?? null;
                $progresso_percentual = $_POST['progresso_percentual'] ?? 0;
                if (!$id || !$nome || !$descricao || !$localizacao) {
                    throw new Exception("Campos obrigatórios faltando");
                }
                $stmt = $pdo->prepare("
                    UPDATE projetos 
                    SET nome = ?, descricao = ?, localizacao = ?, progresso_percentual = ?
                    WHERE id = ?
                ");
                $stmt->execute([$nome, $descricao, $localizacao, $progresso_percentual, $id]);
                header("Location: ../admin.php?aba=projetos&success=projeto_atualizado");
            }
            break;
        case 'delete_projeto':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception("ID não fornecido");
            }
            $stmt = $pdo->prepare("DELETE FROM projetos WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: ../admin.php?aba=projetos&success=projeto_deletado");
            break;
        case 'create_admin':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'] ?? null;
                $nome_completo = $_POST['nome_completo'] ?? null;
                $email = $_POST['email'] ?? null;
                $password = $_POST['password'] ?? null;
                $password_confirm = $_POST['password_confirm'] ?? null;
                $code_2fa = $_POST['code_2fa'] ?? '123456';
                if (!$username || !$nome_completo || !$email || !$password) {
                    throw new Exception("Campos obrigatórios faltando");
                }
                if ($password !== $password_confirm) {
                    header("Location: ../admin.php?aba=admins&error=senhas_nao_conferem");
                    exit;
                }
                if (strlen($password) < 8) {
                    header("Location: ../admin.php?aba=admins&error=senha_muito_curta");
                    exit;
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    header("Location: ../admin.php?aba=admins&error=email_invalido");
                    exit;
                }
                if (!empty($code_2fa) && (!is_numeric($code_2fa) || strlen($code_2fa) > 6)) {
                    header("Location: ../admin.php?aba=admins&error=code_2fa_invalido");
                    exit;
                }
                $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE username = ? OR email = ?");
                $stmt->execute([$username, $email]);
                if ($stmt->fetch()) {
                    header("Location: ../admin.php?aba=admins&error=usuario_email_existem");
                    exit;
                }
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("
                    INSERT INTO usuarios (username, nome_completo, email, password_hash, code_2fa, is_admin, data_criacao, data_atualizacao)
                    VALUES (?, ?, ?, ?, ?, 1, NOW(), NOW())
                ");
                $stmt->execute([$username, $nome_completo, $email, $password_hash, $code_2fa]);
                header("Location: ../admin.php?aba=admins&success=admin_criado");
            }
            break;
        case 'delete_admin':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception("ID não fornecido");
            }
            if ($id == $_SESSION['user_id']) {
                header("Location: ../admin.php?aba=admins&error=nao_pode_deletar_a_si");
                exit;
            }
            $stmt = $pdo->prepare("SELECT is_admin FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            if (!$user || !$user['is_admin']) {
                throw new Exception("Usuário não é admin");
            }
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND is_admin = 1");
            $stmt->execute([$id]);
            header("Location: ../admin.php?aba=admins&success=admin_removido");
            break;
        default:
            header("Location: ../admin.php");
            break;
    }
} catch (PDOException $e) {
    error_log("Erro CRUD: " . $e->getMessage());
    header("Location: ../admin.php?error=erro_banco_dados");
    exit;
} catch (Exception $e) {
    error_log("Erro: " . $e->getMessage());
    header("Location: ../admin.php?error=erro_operacao");
    exit;
}
?>
