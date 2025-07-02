<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

// Redireciona a raiz para a rota de login (pode mudar se quiser)
Route::redirect('/', '/login');

// Rotas protegidas por autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard, se quiser manter
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas do CRUD de tarefas protegidas
    Route::resource('tarefas', TarefaController::class);

    // Rotas do perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas de autenticação (login, registro, etc)
require __DIR__.'/auth.php';
