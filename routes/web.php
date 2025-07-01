<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController; // ← Importa o controller

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('tarefas.index');
});

// Rotas do CRUD de tarefas
Route::resource('tarefas', TarefaController::class);
