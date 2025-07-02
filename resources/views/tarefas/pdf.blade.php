<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <h2>Lista de Tarefas</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Descrição</th>
                <th>Data Criação</th>
                <th>Data Prevista</th>
                <th>Data Encerramento</th>
                <th>Situação</th>
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
                    <td>{{ ucfirst($tarefa->situacao) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
