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

// Inserir nova tarefa no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tarefa = $_POST['tarefa'];
    $descricao = $_POST['descricao'];
    $prazo = $_POST['prazo'];
    $prioridade = $_POST['prioridade'];
    $concluida = isset($_POST['concluida']) ? 1 : 0;
    $lembrete = isset($_POST['lembrete']) ? 1 : 0;

    // Use prepared statements para evitar SQL Injection
    $stmt = $conn->prepare("INSERT INTO tarefas (tarefa, descricao, prazo, prioridade, concluida, lembrete) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssii", $tarefa, $descricao, $prazo, $prioridade, $concluida, $lembrete);

    if ($stmt->execute()) {
        echo "Nova tarefa adicionada com sucesso";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

// Recuperar tarefas do banco de dados
$sql = "SELECT * FROM tarefas";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1 id="titulo">Gerenciador de Tarefas</h1>
<form method="post" action="">
    <fieldset class="field">
        <legend>Nova Tarefa</legend>
        <p>
            <label for="tarefa">Tarefa:</label>
            <input type="text" name="tarefa" id="tarefa" class="input">
        </p>
        <p>
            <label for="descricao">Descrição (Opcional):</label>
            <textarea name="descricao" id="descricao" class="input"></textarea>
        </p>
        <p>
            <label for="prazo">Prazo (Opcional):</label>
            <input type="date" name="prazo" id="prazo" class="input">
        </p>
        <fieldset class="fieldentro">
            <legend>Prioridade</legend>
            <p class="prioridade">
                <input type="radio" name="prioridade" id="baixo" value="Baixa">
                <label for="baixo">Baixa</label>

                <input type="radio" name="prioridade" id="medio" value="Média">
                <label for="medio">Média</label>

                <input type="radio" name="prioridade" id="alto" value="Alta">
                <label for="alto">Alta</label>
            </p>
        </fieldset>
        <p>
            <label for="concluida">Tarefa concluída:</label>
            <input type="checkbox" name="concluida" id="concluida">
        </p>
        <p>
            <label for="lembrete">Lembrete por e-mail:</label>
            <input type="checkbox" name="lembrete" id="lembrete">
        </p>

        <button type="submit" class="btn">Cadastrar</button>
    </fieldset>
</form>

<table class="table">
    <tr class="th">
        <th>Tarefa</th>
        <th>Descrição</th>
        <th>Prazo</th>
        <th>Prioridade</th>
        <th>Concluída</th>
        <th>Opções</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="tr">
            <td><?php echo htmlspecialchars($row['tarefa']); ?></td>
            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
            <td><?php echo htmlspecialchars($row['prazo']); ?></td>
            <td><?php echo htmlspecialchars($row['prioridade']); ?></td>
            <td><?php echo $row['concluida'] ? 'Sim' : 'Não'; ?></td>
            <td><a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                <a href="remover.php?id=<?php echo $row['id']; ?>">Remover</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>

<?php $conn->close(); ?>
