<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'ativo',
        'status_inicial',
        'status_atual',
        'usuario_criacao',
    ];

    // Relação com as etapas (um processo pode ter várias etapas)
    public function etapas()
    {
        return $this->hasMany(Etapa::class);
    }
}
