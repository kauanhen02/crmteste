<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'categorias'; // Nome da tabela

    protected $fillable = [
        'id',
        'nome',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    function linhas()
    {
        return $this->hasMany(Linha::class, 'categoria_id');
    }

    function linhasAtivas()
    {
        return $this->hasMany(Linha::class, 'categoria_id')->where('status', 1);
    }

}
