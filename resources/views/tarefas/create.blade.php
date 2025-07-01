<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nova Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">📝 Nova Tarefa</h2>

    <form action="{{ route('tarefas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input type="text" name="descricao" class="form-control" placeholder="Descrição da tarefa" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Data de Criação</label>
            <input type="date" name="data_criacao" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Data Prevista</label>
            <input type="date" name="data_prevista" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Data de Encerramento</label>
            <input type="date" name="data_encerramento" class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label">Situação</label>
            <select name="situacao" class="form-select">
                <option value="pendente">Pendente</option>
                <option value="em andamento">Em Andamento</option>
                <option value="concluída">Concluída</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('tarefas.index') }}" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
