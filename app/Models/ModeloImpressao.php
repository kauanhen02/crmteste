<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModeloImpressao extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'modelos_impressao'; // Nome da tabela

    protected $fillable = [
        'id',
        'nome',
        'texto',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
