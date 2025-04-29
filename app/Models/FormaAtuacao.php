<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormaAtuacao extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'formas_atuacoes'; // Nome da tabela

    protected $fillable = [
        'id',
        'nome',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
