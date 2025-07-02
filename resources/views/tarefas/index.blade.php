<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Tarefas</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Tarefas</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('tarefas.create') }}" class="btn btn-primary">Nova Tarefa</a>
    
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Sair</button>
            </form>
        </div>
    </div>

    <form method="GET" action="{{ route('tarefas.index') }}" class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" name="descricao" value="{{ request('descricao') }}" class="form-control" placeholder="Buscar por descrição...">
        </div>
        <div class="col-md-4">
            <select name="situacao" class="form-select">
                <option value="">-- Situação --</option>
                <option value="pendente" {{ request('situacao') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="em andamento" {{ request('situacao') == 'em andamento' ? 'selected' : '' }}>Em Andamento</option>
                <option value="concluída" {{ request('situacao') == 'concluída' ? 'selected' : '' }}>Concluída</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
        </div>
    </form>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($tarefas->count() > 0)
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Descrição</th>
                <th>Data Criação</th>
                <th>Data Prevista</th>
                <th>Data Encerramento</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($tarefas as $tarefa)
            <tr>
                <td>{{ $tarefa->id }}</td>
                <td>{{ $tarefa->descricao }}</td>
                <td>{{ \Carbon\Carbon::parse($tarefa->data_criacao)->format('d/m/Y') }}</td>
                <td>{{ $tarefa->data_prevista ? \Carbon\Carbon::parse($tarefa->data_prevista)->format('d/m/Y') : '-' }}</td>
                <td>{{ $tarefa->data_encerramento ? \Carbon\Carbon::parse($tarefa->data_encerramento)->format('d/m/Y') : '-' }}</td>
                <td>
                    @if ($tarefa->situacao == 'pendente')
                        <span class="badge bg-warning text-dark">Pendente</span>
                    @elseif ($tarefa->situacao == 'em andamento')
                        <span class="badge bg-info text-dark">Em andamento</span>
                    @elseif ($tarefa->situacao == 'concluída')
                        <span class="badge bg-success">Concluída</span>
                    @else
                        <span class="badge bg-secondary">{{ $tarefa->situacao }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Confirma exclusão da tarefa?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <p>Nenhuma tarefa cadastrada.</p>
    @endif

</div>

<!-- Bootstrap JS Bundle com Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
