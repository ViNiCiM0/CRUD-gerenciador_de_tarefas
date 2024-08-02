<?php

// Configuração do banco de dados
$servername = "localhost:3309";
$username = "root";
$password = "root"; // Coloque a senha do seu banco de dados aqui
$dbname = "gerenciador_de_tarefas"; // Substitua pelo nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ID da tarefa foi passado
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Use prepared statements para evitar SQL Injection
    $stmt = $conn->prepare("DELETE FROM tarefas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirecionar para a página principal após a exclusão
        header("Location: gerenciador.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID da tarefa não especificado.";
}

$conn->close();


