<?php
require_once 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $birth = $_POST['birth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $motherName = $_POST['motherName'] ?? '';
    $cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
    $phone = preg_replace('/\D/', '', $_POST['phone'] ?? '');
    $cep = preg_replace('/\D/', '', $_POST['cep'] ?? '');
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $neighborhood = $_POST['neighboorhood'] ?? '';
    $street = $_POST['street'] ?? '';
    $number = $_POST['number'] ?? '';
    $complement = $_POST['complement'] ?? '';
    $uf = $_POST['uf'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $secret_question = $_POST['secret_question'] ?? '';
    $secret_answer = trim($_POST['secret_answer'] ?? '');
    $campos_obrigatorios = [
        'name' => $name,
        'email' => $email,
        'birth' => $birth,
        'gender' => $gender,
        'motherName' => $motherName,
        'cpf' => $cpf,
        'phone' => $phone,
        'cep' => $cep,
        'city' => $city,
        'state' => $state,
        'neighborhood' => $neighborhood,
        'street' => $street,
        'number' => $number,
        'uf' => $uf,
        'password' => $password,
        'confirmPassword' => $confirmPassword,
        'secret_question' => $secret_question,
        'secret_answer' => $secret_answer
    ];
    $campos_faltando = [];
    foreach ($campos_obrigatorios as $campo => $valor) {
        if (empty($valor)) {
            $campos_faltando[] = $campo;
        }
    }
    if (!empty($campos_faltando)) {
        echo '<div class="erro">Preencha todos os campos! Faltando: ' . implode(', ', $campos_faltando) . '</div>';
        exit;
    }
    if ($password !== $confirmPassword) {
        echo '<div class="erro">As senhas não coincidem!</div>';
        exit;
    }
    $username = explode('@', $email)[0];
    $nome_partes = explode(' ', $name);
    $primeiro_nome = $nome_partes[0];
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        echo '<div class="erro">Erro: Nome de usuário ou e-mail já existe!</div>';
        exit;
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    try {
        $sql = "INSERT INTO usuarios (nome_completo, data_nascimento, genero, nome_mae, pergunta_secreta, resposta_secreta, cpf, celular, cep, uf, cidade, estado, rua, numero, bairro, complemento, email, password_hash, username) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $name, $birth, $gender, $motherName, $secret_question, $secret_answer, 
            $cpf, $phone, $cep, $uf, $city, $state, $street, $number, $neighborhood, $complement, 
            $email, $password_hash, $username
        ]);
        $_SESSION['registro_sucesso'] = 'Usuário registrado com sucesso! Faça login agora.';
        echo '<script>
            alert("✅ Registro realizado com sucesso!\\n\\nUsername: ' . $username . '\\nEmail: ' . $email . '\\n\\nAgora faça login com suas credenciais.");
            window.location.href = "../login.php";
        </script>';
        exit;
    } catch (PDOException $e) {
        echo '<div class="erro">Erro ao registrar: ' . $e->getMessage() . '</div>';
    }
}
?>
