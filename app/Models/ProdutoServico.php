<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdutoServico extends Model
{
    use SoftDeletes, RegistroLog, PesquisaPadraoSupport;
    
    protected $table = 'produtos_servicos';

    protected $fillable = [
        'grupo_id',
        'sub_grupo_id',
        'descricao',
        'descricao_popular',
        'cod',
        'custo_medio_ponderado'
    ];

    function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    function grupoTrashed()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id')->withTrashed();
    }

    function subGrupo()
    {
        return $this->belongsTo(SubGrupo::class, 'sub_grupo_id');
    }

    function subGrupoTrashed()
    {
        return $this->belongsTo(SubGrupo::class, 'sub_grupo_id')->withTrashed();
    }
}
