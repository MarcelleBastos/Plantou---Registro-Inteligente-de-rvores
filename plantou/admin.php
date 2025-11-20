<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}
require_once 'includes/db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE usuarios SET 
            username = :username,
            nome_completo = :nome_completo,
            data_nascimento = :data_nascimento,
            genero = :genero,
            nome_mae = :nome_mae,
            cpf = :cpf,
            celular = :celular,
            cep = :cep,
            cidade = :cidade,
            bairro = :bairro,
            rua = :rua,
            numero = :numero,
            complemento = :complemento,
            uf = :uf,
            estado = :estado,
            email = :email,
            data_atualizacao = NOW(),
            is_admin = :is_admin
            WHERE id = :id");
        $stmt->execute([
            ':username' => $_POST['username'],
            ':nome_completo' => $_POST['nome_completo'],
            ':data_nascimento' => $_POST['data_nascimento'],
            ':genero' => $_POST['genero'],
            ':nome_mae' => $_POST['nome_mae'],
            ':cpf' => $_POST['cpf'],
            ':celular' => $_POST['celular'],
            ':cep' => $_POST['cep'],
            ':cidade' => $_POST['cidade'],
            ':bairro' => $_POST['bairro'],
            ':rua' => $_POST['rua'],
            ':numero' => $_POST['numero'],
            ':complemento' => $_POST['complemento'],
            ':uf' => $_POST['uf'],
            ':estado' => $_POST['estado'],
            ':email' => $_POST['email'],
            ':is_admin' => isset($_POST['is_admin']) ? 1 : 0,
            ':id' => $id
        ]);
        header("Location: admin.php?msg=updated");
        exit();
    }
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header("Location: admin.php?msg=deleted");
        exit();
    }
}
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id ASC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
try {
    $stmt = $pdo->prepare("SELECT * FROM doacoes ORDER BY data_doacao DESC");
    $stmt->execute();
    $doacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT * FROM arvores ORDER BY id DESC");
    $stmt->execute();
    $arvores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT * FROM projetos ORDER BY id DESC");
    $stmt->execute();
    $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao buscar dados: " . $e->getMessage());
    $doacoes = [];
    $arvores = [];
    $projetos = [];
}
$aba_ativa = $_GET['aba'] ?? 'doacoes';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Plantou!</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    <section class="hero" style="background: var(--deep-wood); padding: 40px 0; text-align: center;">
        <div class="container">
            <h1 style="color: var(--cream-white); margin-bottom: 10px;">
                PAINEL ADMINISTRATIVO
            </h1>
            <p style="color: var(--light-soil); font-size: 1.1rem;">
                Gerenciar Plantou!
            </p>
        </div>
    </section>
    <section class="content" style="padding: 40px 0;">
        <div class="container">
            <!-- ABAS DE NAVEGAÇÃO -->
            <div style="display: flex; gap: 10px; margin-bottom: 30px; flex-wrap: wrap;">
                <a href="admin.php?aba=doacoes" class="btn <?php echo ($aba_ativa === 'doacoes') ? 'btn-primary' : 'btn-secondary'; ?>" style="text-decoration: none; display: inline-block;">DOAÇÕES</a>
                <a href="admin.php?aba=arvores" class="btn <?php echo ($aba_ativa === 'arvores') ? 'btn-primary' : 'btn-secondary'; ?>" style="text-decoration: none; display: inline-block;">ÁRVORES</a>
                <a href="admin.php?aba=projetos" class="btn <?php echo ($aba_ativa === 'projetos') ? 'btn-primary' : 'btn-secondary'; ?>" style="text-decoration: none; display: inline-block;">PROJETOS</a>
                <a href="admin.php?aba=usuarios" class="btn <?php echo ($aba_ativa === 'usuarios') ? 'btn-primary' : 'btn-secondary'; ?>" style="text-decoration: none; display: inline-block;">👥 USUÁRIOS</a>
                <a href="admin.php?aba=admins" class="btn <?php echo ($aba_ativa === 'admins') ? 'btn-primary' : 'btn-secondary'; ?>" style="text-decoration: none; display: inline-block; background: var(--accent-orange);">👨‍💼 ADMINS</a>
            </div>
            <!-- MENSAGENS DE SUCESSO/ERRO -->
            <?php 
            $success = $_GET['success'] ?? null;
            $error = $_GET['error'] ?? null;
            $messages = [
                'admin_criado' => '✅ Admin criado com sucesso!',
                'admin_removido' => '✅ Admin removido com sucesso!',
                'usuario_email_existem' => '❌ Este usuário ou email já existe',
                'senhas_nao_conferem' => '❌ As senhas não conferem',
                'senha_muito_curta' => '❌ A senha deve ter pelo menos 8 caracteres',
                'email_invalido' => '❌ Email inválido',
                'nao_pode_deletar_a_si' => '❌ Você não pode remover sua própria conta',
                'code_2fa_invalido' => '❌ Código 2FA inválido. Use apenas números (máximo 6 dígitos)',
            ];
            if ($success && isset($messages[$success])): ?>
                <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #4caf50;">
                    <?php echo $messages[$success]; ?>
                </div>
            <?php endif; ?>
            <?php if ($error && isset($messages[$error])): ?>
                <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #c62828;">
                    <?php echo $messages[$error]; ?>
                </div>
            <?php endif; ?>
            <!-- ABA DOAÇÕES -->
            <?php if ($aba_ativa === 'doacoes'): ?>
            <div>
                <h2 class="section-title">GERENCIAR DOAÇÕES</h2>
                <!-- BOTÃO ADICIONAR -->
                <div style="margin-bottom: 20px;">
                    <button type="button" id="btn-add-doacao" class="btn btn-primary" onclick="toggleForm('novo-doacao')">+ ADICIONAR DOAÇÃO</button>
                </div>
                <!-- FORMULÁRIO ADICIONAR DOAÇÃO -->
                <div id="novo-doacao" class="form-card" style="display: none; margin-bottom: 30px; padding: 20px;">
                    <h3>Nova Doação</h3>
                    <form action="includes/crud_process.php" method="POST">
                        <input type="hidden" name="acao" value="create_doacao">
                        <div class="form-group">
                            <label for="user_id">ID do Usuário:</label>
                            <input type="number" id="user_id" name="user_id" required>
                        </div>
                        <div class="form-group">
                            <label for="valor_doacao">Valor (R$):</label>
                            <input type="number" id="valor_doacao" name="valor_doacao" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status" required>
                                <option value="pendente">Pendente</option>
                                <option value="confirmado">Confirmado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('novo-doacao')">Cancelar</button>
                    </form>
                </div>
                <!-- TABELA DOAÇÕES -->
                <?php if (count($doacoes) > 0): ?>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--dark-forest); color: var(--cream-white);">
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">ID</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">User ID</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Valor</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Data</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Status</th>
                                <th style="padding: 12px; text-align: center; border: 3px solid var(--dark-forest);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doacoes as $doacao): ?>
                                <tr style="background: var(--cream-white); border: 3px solid var(--dark-forest);">
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($doacao['id']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($doacao['user_id']); ?></td>
                                    <td style="padding: 12px;">R$ <?php echo number_format($doacao['valor_doacao'], 2, ',', '.'); ?></td>
                                    <td style="padding: 12px;"><?php echo date('d/m/Y', strtotime($doacao['data_doacao'])); ?></td>
                                    <td style="padding: 12px;">
                                        <span style="background: <?php echo ($doacao['status'] === 'confirmado') ? 'var(--moss-green)' : 'var(--accent-orange)'; ?>; color: var(--cream-white); padding: 5px 10px; font-weight: bold; border: 2px solid <?php echo ($doacao['status'] === 'confirmado') ? 'var(--moss-green)' : 'var(--accent-orange)'; ?>;">
                                            <?php echo strtoupper($doacao['status']); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <button type="button" class="btn btn-secondary" style="font-size: 0.8rem; padding: 5px 10px;" onclick="editarDoacao(<?php echo htmlspecialchars(json_encode($doacao)); ?>)">Editar</button>
                                        <a href="includes/crud_process.php?acao=delete_doacao&id=<?php echo $doacao['id']; ?>" class="btn btn-secondary" style="font-size: 0.8rem; padding: 5px 10px; text-decoration: none; display: inline-block;" onclick="return confirm('Tem certeza?');">Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="form-card" style="text-align: center; padding: 30px;">
                        <p>Nenhuma doação registrada.</p>
                    </div>
                <?php endif; ?>
            </div>
            <!-- ABA ÁRVORES -->
            <?php elseif ($aba_ativa === 'arvores'): ?>
            <div>
                <h2 class="section-title">GERENCIAR ÁRVORES</h2>
                <!-- BOTÃO ADICIONAR -->
                <div style="margin-bottom: 20px;">
                    <button type="button" id="btn-add-arvore" class="btn btn-primary" onclick="toggleForm('novo-arvore')">+ ADICIONAR ÁRVORE</button>
                </div>
                <!-- FORMULÁRIO ADICIONAR ÁRVORE -->
                <div id="novo-arvore" class="form-card" style="display: none; margin-bottom: 30px; padding: 20px;">
                    <h3>Nova Árvore</h3>
                    <form action="includes/crud_process.php" method="POST">
                        <input type="hidden" name="acao" value="create_arvore">
                        <div class="form-group">
                            <label for="arvore_nome">Nome:</label>
                            <input type="text" id="arvore_nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="arvore_tipo">Tipo:</label>
                            <input type="text" id="arvore_tipo" name="tipo" required>
                        </div>
                        <div class="form-group">
                            <label for="arvore_local">Local:</label>
                            <input type="text" id="arvore_local" name="local" required>
                        </div>
                        <div class="form-group">
                            <label for="arvore_co2">CO₂ Absorvido (kg):</label>
                            <input type="number" id="arvore_co2" name="co2_absorvido" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="arvore_status">Status:</label>
                            <select id="arvore_status" name="status" required>
                                <option value="viva">Viva</option>
                                <option value="seca">Seca</option>
                                <option value="plantada">Plantada</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('novo-arvore')">Cancelar</button>
                    </form>
                </div>
                <!-- TABELA ÁRVORES -->
                <?php if (count($arvores) > 0): ?>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--dark-forest); color: var(--cream-white);">
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">ID</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Nome</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Tipo</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Local</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">CO₂ (kg)</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Status</th>
                                <th style="padding: 12px; text-align: center; border: 3px solid var(--dark-forest);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arvores as $arvore): ?>
                                <tr style="background: var(--cream-white); border: 3px solid var(--dark-forest);">
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($arvore['id']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($arvore['nome']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($arvore['tipo']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($arvore['local']); ?></td>
                                    <td style="padding: 12px;"><?php echo number_format($arvore['co2_absorvido'], 2, ',', '.'); ?></td>
                                    <td style="padding: 12px;">
                                        <span style="background: var(--moss-green); color: var(--cream-white); padding: 5px 10px; font-weight: bold; border: 2px solid var(--moss-green);">
                                            <?php echo strtoupper($arvore['status']); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <button type="button" class="btn btn-secondary" style="font-size: 0.8rem; padding: 5px 10px;" onclick="editarArvore(<?php echo htmlspecialchars(json_encode($arvore)); ?>)">Editar</button>
                                        <a href="includes/crud_process.php?acao=delete_arvore&id=<?php echo $arvore['id']; ?>" class="btn btn-secondary" style="font-size: 0.8rem; padding: 5px 10px; text-decoration: none; display: inline-block;" onclick="return confirm('Tem certeza?');">Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="form-card" style="text-align: center; padding: 30px;">
                        <p>Nenhuma árvore registrada.</p>
                    </div>
                <?php endif; ?>
            </div>
            <!-- ABA PROJETOS -->
            <?php elseif ($aba_ativa === 'projetos'): ?>
            <div>
                <h2 class="section-title">GERENCIAR PROJETOS</h2>
                <!-- BOTÃO ADICIONAR -->
                <div style="margin-bottom: 20px;">
                    <button type="button" id="btn-add-projeto" class="btn btn-primary" onclick="toggleForm('novo-projeto')">+ ADICIONAR PROJETO</button>
                </div>
                <!-- FORMULÁRIO ADICIONAR PROJETO -->
                <div id="novo-projeto" class="form-card" style="display: none; margin-bottom: 30px; padding: 20px;">
                    <h3>Novo Projeto</h3>
                    <form action="includes/crud_process.php" method="POST">
                        <input type="hidden" name="acao" value="create_projeto">
                        <div class="form-group">
                            <label for="projeto_nome">Nome:</label>
                            <input type="text" id="projeto_nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="projeto_descricao">Descrição:</label>
                            <textarea id="projeto_descricao" name="descricao" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="projeto_localizacao">Localização:</label>
                            <input type="text" id="projeto_localizacao" name="localizacao" required>
                        </div>
                        <div class="form-group">
                            <label for="projeto_progresso">Progresso (%):</label>
                            <input type="number" id="projeto_progresso" name="progresso_percentual" min="0" max="100" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('novo-projeto')">Cancelar</button>
                    </form>
                </div>
                <!-- TABELA PROJETOS -->
                <?php if (count($projetos) > 0): ?>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--dark-forest); color: var(--cream-white);">
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">ID</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Nome</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Localização</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Progresso</th>
                                <th style="padding: 12px; text-align: center; border: 3px solid var(--dark-forest);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projetos as $projeto): ?>
                                <tr style="background: var(--cream-white); border: 3px solid var(--dark-forest);">
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($projeto['id']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($projeto['nome']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($projeto['localizacao']); ?></td>
                                    <td style="padding: 12px;">
                                        <div style="background: var(--stone-gray); border: 2px solid var(--dark-forest); width: 100px; height: 20px; position: relative;">
                                            <div style="background: var(--accent-orange); width: <?php echo $projeto['progresso_percentual']; ?>%; height: 100%;"></div>
                                        </div>
                                        <small><?php echo $projeto['progresso_percentual']; ?>%</small>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <button type="button" class="btn btn-secondary" style="font-size: 0.8rem; padding: 5px 10px;" onclick="editarProjeto(<?php echo htmlspecialchars(json_encode($projeto)); ?>)">Editar</button>
                                        <a href="includes/crud_process.php?acao=delete_projeto&id=<?php echo $projeto['id']; ?>" class="btn btn-secondary" style="font-size: 0.8rem; padding: 5px 10px; text-decoration: none; display: inline-block;" onclick="return confirm('Tem certeza?');">Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="form-card" style="text-align: center; padding: 30px;">
                        <p>Nenhum projeto registrado.</p>
                    </div>
                <?php endif; ?>
            </div>
            <!-- ABA USUÁRIOS -->
            <?php elseif ($aba_ativa === 'usuarios'): ?>
            <div>
                <h2 class="section-title">GERENCIAR USUÁRIOS</h2>
                <div style="background: linear-gradient(135deg, var(--cream-white) 0%, #f8f9fa 100%); padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
                        <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #4caf50; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-check-circle"></i>
                            <span>Usuário atualizado com sucesso!</span>
                        </div>
                    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
                        <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #f44336; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Usuário excluído com sucesso!</span>
                        </div>
                    <?php endif; ?>
                    
                    <div style="overflow-x: auto; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <table style="width: 100%; border-collapse: collapse; background: white; font-size: 13px;">
                            <thead>
                                <tr style="background: linear-gradient(135deg, var(--dark-forest) 0%, #2d5a4a 100%); color: var(--cream-white);">
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); white-space: nowrap;">ID</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 120px;">Usuário</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 150px;">Nome Completo</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 130px;">Nascimento</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 100px;">Gênero</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 130px;">Nome da Mãe</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 120px;">CPF</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 120px;">Celular</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 90px;">CEP</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 100px;">Cidade</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 100px;">Bairro</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 120px;">Rua</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 80px;">Nº</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 120px;">Complemento</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 60px;">UF</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 100px;">Estado</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 150px;">Email</th>
                                    <th style="padding: 15px 10px; text-align: center; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 70px;">Admin?</th>
                                    <th style="padding: 15px 10px; text-align: left; font-weight: 600; border-right: 1px solid rgba(255,255,255,0.1); min-width: 140px;">Atualizado em</th>
                                    <th style="padding: 15px 10px; text-align: center; font-weight: 600; min-width: 140px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $index => $user): ?>
                                <tr style="background: <?php echo ($index % 2 == 0) ? '#ffffff' : '#f8f9fa'; ?>; transition: all 0.2s ease; border-bottom: 1px solid #e9ecef;">
                                    <form method="post" style="display: contents;">
                                        <td style="padding: 12px 10px; border-right: 1px solid #e9ecef; font-weight: 600; color: var(--dark-forest);"><?= $user['id'] ?></td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;" 
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="nome_completo" value="<?= htmlspecialchars($user['nome_completo']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="date" name="data_nascimento" value="<?= $user['data_nascimento'] ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <select name="genero" style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease; background: white;"
                                                    onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                    onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                                <option value="masculino" <?= $user['genero'] === 'masculino' ? 'selected' : '' ?>>Masculino</option>
                                                <option value="feminino" <?= $user['genero'] === 'feminino' ? 'selected' : '' ?>>Feminino</option>
                                                <option value="outro" <?= $user['genero'] === 'outro' ? 'selected' : '' ?>>Outro</option>
                                            </select>
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="nome_mae" value="<?= htmlspecialchars($user['nome_mae']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="cpf" value="<?= htmlspecialchars($user['cpf']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="celular" value="<?= htmlspecialchars($user['celular']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="cep" value="<?= htmlspecialchars($user['cep']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="cidade" value="<?= htmlspecialchars($user['cidade']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="bairro" value="<?= htmlspecialchars($user['bairro']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="rua" value="<?= htmlspecialchars($user['rua']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="numero" value="<?= htmlspecialchars($user['numero']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="complemento" value="<?= htmlspecialchars($user['complemento']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="uf" value="<?= htmlspecialchars($user['uf']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="text" name="estado" value="<?= htmlspecialchars($user['estado']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 8px; border-right: 1px solid #e9ecef;">
                                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                                                   style="width: 100%; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; transition: all 0.2s ease;"
                                                   onfocus="this.style.borderColor='var(--moss-green)'; this.style.boxShadow='0 0 5px rgba(76,175,80,0.3)'"
                                                   onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                                        </td>
                                        <td style="padding: 12px 10px; text-align: center; border-right: 1px solid #e9ecef;">
                                            <input type="checkbox" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?> 
                                                   style="transform: scale(1.2); accent-color: var(--moss-green);">
                                        </td>
                                        <td style="padding: 12px 10px; border-right: 1px solid #e9ecef; font-size: 11px; color: #666;">
                                            <?= htmlspecialchars($user['data_atualizacao']) ?>
                                        </td>
                                        <td style="padding: 8px; text-align: center;">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <div style="display: flex; gap: 4px; justify-content: center;">
                                                <button type="submit" name="update" 
                                                        style="background: linear-gradient(135deg, var(--moss-green) 0%, #45a049 100%); color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 11px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 4px;"
                                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(76,175,80,0.3)'"
                                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                    <i class="fas fa-save" style="font-size: 10px;"></i>
                                                    Salvar
                                                </button>
                                                <button type="submit" name="delete" 
                                                        onclick="return confirm('Deseja realmente excluir este usuário?');"
                                                        style="background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 11px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 4px;"
                                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(244,67,54,0.3)'"
                                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                    <i class="fas fa-trash" style="font-size: 10px;"></i>
                                                    Excluir
                                                </button>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ABA ADMINS -->
            <?php elseif ($aba_ativa === 'admins'): ?>
            <div>
                <h2 class="section-title">GERENCIAR CONTAS DE ADMIN</h2>
                <!-- BOTÃO ADICIONAR -->
                <div style="margin-bottom: 20px;">
                    <button type="button" id="btn-add-admin" class="btn btn-primary" onclick="toggleForm('novo-admin')">+ CRIAR NOVO ADMIN</button>
                </div>
                <!-- FORMULÁRIO ADICIONAR ADMIN -->
                <div id="novo-admin" class="form-card" style="display: none; margin-bottom: 30px; padding: 20px;">
                    <h3>Nova Conta de Admin</h3>
                    <form action="includes/crud_process.php" method="POST">
                        <input type="hidden" name="acao" value="create_admin">
                        <div class="form-group">
                            <label for="admin_username">Nome de Usuário:</label>
                            <input type="text" id="admin_username" name="username" required minlength="3">
                        </div>
                        <div class="form-group">
                            <label for="admin_nome_completo">Nome Completo:</label>
                            <input type="text" id="admin_nome_completo" name="nome_completo" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Email:</label>
                            <input type="email" id="admin_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_password">Senha:</label>
                            <input type="password" id="admin_password" name="password" required minlength="8" placeholder="Mínimo 8 caracteres">
                        </div>
                        <div class="form-group">
                            <label for="admin_password_confirm">Confirmar Senha:</label>
                            <input type="password" id="admin_password_confirm" name="password_confirm" required minlength="8" placeholder="Repita a senha">
                        </div>
                        <div class="form-group">
                            <label for="admin_2fa_code">Código 2FA:</label>
                            <input type="text" id="admin_2fa_code" name="code_2fa" placeholder="Ex: 999888" maxlength="6" pattern="[0-9]*" inputmode="numeric">
                        </div>
                        <button type="submit" class="btn btn-primary">Criar Admin</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('novo-admin')">Cancelar</button>
                    </form>
                </div>
                <!-- BUSCAR ADMINS -->
                <?php 
                try {
                    $stmt = $pdo->prepare("SELECT id, username, nome_completo, email, code_2fa, data_criacao FROM usuarios WHERE is_admin = 1 ORDER BY data_criacao DESC");
                    $stmt->execute();
                    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $admins = [];
                }
                ?>
                <!-- TABELA ADMINS -->
                <?php if (count($admins) > 0): ?>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--dark-forest); color: var(--cream-white);">
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">ID</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Usuário</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Nome Completo</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Email</th>
                                <th style="padding: 12px; text-align: center; border: 3px solid var(--dark-forest);">🔐 Código 2FA</th>
                                <th style="padding: 12px; text-align: left; border: 3px solid var(--dark-forest);">Criado em</th>
                                <th style="padding: 12px; text-align: center; border: 3px solid var(--dark-forest);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $admin): ?>
                                <tr style="background: var(--cream-white); border: 3px solid var(--dark-forest);">
                                    <td style="padding: 12px;"><strong><?php echo htmlspecialchars($admin['id']); ?></strong></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($admin['username']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($admin['nome_completo']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($admin['email']); ?></td>
                                    <td style="padding: 12px; text-align: center;">
                                        <code style="background: #f0f0f0; padding: 5px 10px; border-radius: 3px; font-weight: bold; color: var(--dark-forest);">
                                            <?php echo htmlspecialchars($admin['code_2fa']); ?>
                                        </code>
                                    </td>
                                    <td style="padding: 12px;"><?php echo date('d/m/Y H:i', strtotime($admin['data_criacao'])); ?></td>
                                    <td style="padding: 12px; text-align: center;">
                                        <?php if ($admin['id'] !== $_SESSION['user_id']): ?>
                                            <a href="includes/crud_process.php?acao=delete_admin&id=<?php echo $admin['id']; ?>" class="btn btn-secondary" style="font-size: 0.8rem; padding: 5px 10px; text-decoration: none; display: inline-block;" onclick="return confirm('Tem certeza que deseja remover este admin?');">Remover</a>
                                        <?php else: ?>
                                            <span style="color: var(--moss-green); font-weight: bold;">👤 Você</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="form-card" style="text-align: center; padding: 30px;">
                        <p>Nenhum admin encontrado.</p>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
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
    </footer>
    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
        function toggleForm(formId) {
            const form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
        function editarDoacao(doacao) {
            alert('Função de edição em desenvolvimento.\n\nID: ' + doacao.id + '\nValor: R$ ' + doacao.valor_doacao);
        }
        function editarArvore(arvore) {
            alert('Função de edição em desenvolvimento.\n\nID: ' + arvore.id + '\nNome: ' + arvore.nome);
        }
        function editarProjeto(projeto) {
            alert('Função de edição em desenvolvimento.\n\nID: ' + projeto.id + '\nNome: ' + projeto.nome);
        }
    </script>
</body>
</html>
