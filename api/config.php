<?php
$host = "localhost";
$banco = "BancoDigital";
$usuario = "root";
$senha = "";

// Conecta ao banco
try {
    $conexao = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    echo "Erro na conexão com o banco: " . $e->getMessage();
    exit;
}