<?php
require_once "config.php";

// Pega os dados e se vazio == espaço em branco
$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$senha = $_POST['senha'] ?? '';

// Nao aceita campo vazio, (testado caso apague no proprio site)
if (empty($nome) || empty($cpf) || empty($senha)) {
    echo "Erro: Todos os campos são obrigatórios!";
    exit;
}

try {
    // Falar sobre o prepare
    $stmt = $conexao->prepare("INSERT INTO clientes (nome, cpf, senha, saldo) VALUES (:nome, :cpf, :senha, 0.00)");
    
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':senha', $senha);
    // Ao inves de ler um comando, ele da um apelido para as colunas do Banco e depois da o valor como texto
    // assim, o MySql nao Interpreta o codigo, e sim, apenas salva ou busca algo relacionado em formato de texto.
    // No final, fica salvo algo fora da norma no BD.
    $stmt->execute();

    echo "<h2>Conta criada com sucesso!</h2>";
    echo "<p>Agora você já está no nosso banco de dados.</p>";

} catch (PDOException $e) {
    // Se tentar cadastrar o mesmo CPF, o banco vai barrar por causa do UNIQUE
    if ($e->getCode() == 23000) {
        echo "Erro: Este CPF já está cadastrado!";
    } else {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}

// O correto seria salvar a senha em um "Hash".