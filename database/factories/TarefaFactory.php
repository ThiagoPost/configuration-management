<?php

namespace Database\Factories;

use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Factories\Factory;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
class TarefaFactory extends Factory
{
    protected $model = Tarefa::class;

    public function definition()
    {
        return [
            'descricao' => $this->faker->sentence(),
            'data_criacao' => $this->faker->date(),
            'data_prevista' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'data_encerramento' => null,
            'situacao' => $this->faker->randomElement(['aberta', 'concluida']),
        ];
    }
}
