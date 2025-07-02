<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{   
    use HasFactory;

    protected $fillable = [
        'descricao',
        'data_criacao',
        'data_prevista',
        'data_encerramento',
        'situacao',
    ];
}