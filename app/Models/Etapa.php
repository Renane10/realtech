<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'icone',
        'cor',
        'id_fatura',
        'id_email',
        'id_wpp',
        'id_sms',
    ];

    // Relação com o processo (uma etapa pertence a um processo)
    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }
}