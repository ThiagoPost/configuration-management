<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tarefa::query();

        // Filtro por descrição com LIKE para busca aproximada
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }

        // Filtro por situação exata
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->situacao);
        }

        // Ordena por data_criacao (descendente)
        $tarefas = $query->orderBy('data_criacao', 'desc')->get();

        return view('tarefas.index', compact('tarefas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'descricao' => 'required|string',
            'data_criacao' => 'required|date',
            'data_prevista' => 'nullable|date',
            'data_encerramento' => 'nullable|date',
            'situacao' => 'required|string',
        ]);

        Tarefa::create($data);

        return redirect()->route('tarefas.index')->with('message', 'Tarefa criada com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Tarefa::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        return view('tarefas.edit', compact('tarefa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'descricao' => 'required|string',
            'data_criacao' => 'required|date',
            'data_prevista' => 'nullable|date',
            'data_encerramento' => 'nullable|date',
            'situacao' => 'required|string',
        ]);

        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update($data);

        return redirect()->route('tarefas.index')->with('message', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Tarefa::destroy($id);
        return redirect()->route('tarefas.index')->with('message', 'Tarefa excluída com sucesso!');
    }

    public function exportarPdf()
    {
        $tarefas = Tarefa::all();

        $pdf = Pdf::loadView('tarefas.pdf', compact('tarefas'));

        return $pdf->download('lista_tarefas.pdf');
    }
}
