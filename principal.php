<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
</head>
<body>
    <h1>
        Gerenciador de Tarefas
    </h1>
    <form>
        <fieldset>
            <legend>Nova Tarefa</legend>
            <p>
                <label>Tarefa:</label>
                <input type="text" name="tarefa">
            </p>
            <p>
                <label>Descrição (Opcional):</label>
                <textarea name="descricao"></textarea>
            </p>
            <p>
                <label>Prazo (Opcional):</label>
                <input type="text" name="prazo">
            </p>
            <fieldset>
                <legend>Prioridade</legend>
                <p>
                    <input type="radio" name="prioridade" id="baixo"  />
                    <label for="size_1">Baixa</label>

                    <input type="radio" name="prioridade" id="medio" />
                    <label for="size_2">Média</label>

                    <input type="radio" name="prioridade" id="alto" />
                    <label for="size_3">Alta</label>
                </p>
            </fieldset>
            <p>
                <label>Tarefa concluida:</label>
                <input type="checkbox">
            </p>
            <p>
                <label>Lembrete por e-mail:</label>
                <input type="checkbox">
            </p>

            <button><C></C>adastrar</button>

        </fieldset>

    </form>

</body>
</html>