<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubGrupo extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'sub_grupos'; // Nome da tabela

    protected $fillable = [
        'id',
        'nome',
        'sigla',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

}
