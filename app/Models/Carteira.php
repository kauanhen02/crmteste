<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carteira extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'carteiras'; // Nome da tabela

    protected $fillable = [
        'id',
        'nome',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

}
