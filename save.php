<?php

include ("conexao.php");

$nome = $_POST ['nome'];
$nome = $_POST ['email'];
$senha = $_POST ['senha'];

$sql = "insert into admin (nome, senha) values ('$nome', '$senha')";

if ($conexao -> query($sql) === true) {
    echo "<h3> Login feito com sucesso! </h3>";
    echo "<a href='produtos.html'> Voltar </a> ";
} else {
    echo " Erro ao fazer o login: " . $conexao -> error;
}

$conexao -> close();

?>