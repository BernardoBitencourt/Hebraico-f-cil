<?php
session_start();
include("conexao.php");
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
function voltar(string $msg): void {
    header("Location: login.html?erro=" . urlencode($msg));
    exit;
}
function senhaConfere(string $digitada, string $guardada, string $tabela, int $id, mysqli $c): bool {
    if (password_verify($digitada, $guardada)) { return true; }
    $ehHash = password_get_info($guardada)['algo'] !== null;
    if (!$ehHash && hash_equals($guardada, $digitada)) {
        $novo = password_hash($digitada, PASSWORD_DEFAULT);
        $st = $c->prepare("UPDATE `$tabela` SET senha = ? WHERE id = ?");
        $st->bind_param("si", $novo, $id);
        $st->execute();
        $st->close();
        return true;
}
    return false;
}
if ($email === '' || $senha === '') {
    voltar("Preencha e-mail e senha.");
}

$stmt = $conexao->prepare("SELECT id, nome, email, senha FROM cliente WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($usuario && senhaConfere($senha, $usuario['senha'], 'cliente', (int)$usuario['id'], $conexao)) {
    session_regenerate_id(true);
    $_SESSION = [];
    $_SESSION['tipo']          = 'cliente';
    $_SESSION['usuario_id']    = $usuario['id'];
    $_SESSION['usuario_nome']  = $usuario['nome'];
    $_SESSION['usuario_email'] = $usuario['email'];

    header("Location: index.php");
    exit;
}
voltar("E-mail ou senha incorretos.");