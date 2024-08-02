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

    // Obter dados da tarefa para edição
    $stmt = $conn->prepare("SELECT * FROM tarefas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $task = $result->fetch_assoc();
    } else {
        echo "Tarefa não encontrada.";
        exit();
    }
    $stmt->close();
} else {
    echo "ID da tarefa não especificado.";
    exit();
}

// Atualizar tarefa se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tarefa = $_POST['tarefa'];
    $descricao = $_POST['descricao'];
    $prazo = $_POST['prazo'];
    $prioridade = $_POST['prioridade'];
    $concluida = isset($_POST['concluida']) ? 1 : 0;
    $lembrete = isset($_POST['lembrete']) ? 1 : 0;

    // Atualizar a tarefa no banco de dados
    $stmt = $conn->prepare("UPDATE tarefas SET tarefa = ?, descricao = ?, prazo = ?, prioridade = ?, concluida = ?, lembrete = ? WHERE id = ?");
    $stmt->bind_param("ssssiii", $tarefa, $descricao, $prazo, $prioridade, $concluida, $lembrete, $id);

    if ($stmt->execute()) {
        header("Location: gerenciador.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="css/styleedit.css">
</head>
<body>
<h1 class="title">Editar Tarefa</h1>
<form method="post" action="">
    <fieldset class="field">
        <legend>Editar Tarefa</legend>
        <p>
            <label for="tarefa">Tarefa:</label>
            <input type="text" name="tarefa" id="tarefa" class="input" value="<?php echo htmlspecialchars($task['tarefa']); ?>" required>
        </p>
        <p>
            <label for="descricao">Descrição (Opcional):</label>
            <textarea name="descricao" id="descricao" class="input"><?php echo htmlspecialchars($task['descricao']); ?></textarea>
        </p>
        <p>
            <label for="prazo">Prazo (Opcional):</label>
            <input type="date" name="prazo" id="prazo" class="input" value="<?php echo htmlspecialchars($task['prazo']); ?>">
        </p>
        <fieldset class="fieldentro">
            <legend>Prioridade</legend>
            <p class="prioridade">
                <input type="radio" name="prioridade" id="baixo" value="Baixa" <?php echo $task['prioridade'] == 'Baixa' ? 'checked' : ''; ?>>
                <label for="baixo">Baixa</label>

                <input type="radio" name="prioridade" id="medio" value="Média" <?php echo $task['prioridade'] == 'Média' ? 'checked' : ''; ?>>
                <label for="medio">Média</label>

                <input type="radio" name="prioridade" id="alto" value="Alta" <?php echo $task['prioridade'] == 'Alta' ? 'checked' : ''; ?>>
                <label for="alto">Alta</label>
            </p>
        </fieldset>
        <p>
            <label for="concluida">Tarefa concluída:</label>
            <input type="checkbox" name="concluida" id="concluida" <?php echo $task['concluida'] ? 'checked' : ''; ?>>
        </p>
        <p>
            <label for="lembrete">Lembrete por e-mail:</label>
            <input type="checkbox" name="lembrete" id="lembrete" <?php echo $task['lembrete'] ? 'checked' : ''; ?>>
        </p>

        <button type="submit" class="btn">Salvar Alterações</button>
    </fieldset>
</form>
</body>
</html>


