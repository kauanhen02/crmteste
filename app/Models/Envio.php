<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Envio extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'envios'; // Nome da tabela

    protected $fillable = [
        'id',
        'nome',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
