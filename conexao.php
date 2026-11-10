<?php
$servidor = "";
$user = "";
$senha = "";
$banco =  "";
$port = ;

$conexao = new mysqli ($servidor, $user, $senha, $banco);

if ($conexao -> connect_error) {
    die ("falha na conexao: " . $conexao -> connect_error);
}

$conexao -> set_charset("utf8mb4");
?>