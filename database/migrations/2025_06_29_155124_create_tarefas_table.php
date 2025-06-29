<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->timestamp('data_criacao')->useCurrent();
            $table->date('data_prevista');
            $table->date('data_encerramento')->nullable();
            $table->string('situacao'); // Exemplo: pendente, em_andamento, concluida
            $table->timestamps(); // cria os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
