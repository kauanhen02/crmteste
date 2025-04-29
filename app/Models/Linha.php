<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Linha extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'linhas'; // Nome da tabela

    protected $fillable = [
        'id',
        'categoria_id',
        'nome',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    function categoriaTrashed()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id')->withTrashed();
    }
}
