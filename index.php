<?php
$servername = "38.72.132.121"; // Nome do servidor
$username = "root"; // Nome de usuário do banco de dados
$password = "Ts22082020"; // Senha do banco de dados
$dbname = "onepositive"; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo "Conexão bem-sucedida com o banco de dados.";

// Fechar conexão
$conn->close();
?>
