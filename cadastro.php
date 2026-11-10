<?php
session_start();
include("conexao.php");
$nome  = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
if (empty($nome) || empty($email) || empty($senha)) {
    header("Location: login.html?erro=Preencha todos os campos");
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: login.html?erro=E-mail inválido");
    exit;
}

$stmt = $conexao->prepare("SELECT id FROM cliente WHERE email = ?");
if ($stmt) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        header("Location: login.html?erro=Este e-mail já está cadastrado");
        exit;
    }
    $stmt->close();
}
$stmt = $conexao->prepare("SELECT id FROM cliente WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: login.html?erro=Este e-mail já está cadastrado");
    exit;
}
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $conexao->prepare("INSERT INTO cliente (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha_hash);

if ($stmt->execute()) {
    session_regenerate_id(true);
    $_SESSION['tipo']          = 'cliente';
    $_SESSION['usuario_id']    = $stmt->insert_id;
    $_SESSION['usuario_nome']  = $nome;
    $_SESSION['usuario_email'] = $email;
    header("Location: login.html?sucesso=Conta criada com sucesso");
    exit;
} else {
    header("Location: login.html?erro=Erro ao cadastrar");
    exit;
}
$stmt->close();
$conexao->close();
?>