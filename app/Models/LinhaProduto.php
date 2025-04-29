<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinhaProduto extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'atendimento_has_linhas'; // Nome da tabela

    protected $fillable = [
        'atendimento_id',
        'linha_id',
        'volume_id',
        'categoria_id',
        'quantidade',
        'custo_venda_minimo',
        'custo_venda_maximo',
        'aplicacao_minimo',
        'aplicacao_maximo',
        'numero_sugestoes',
        'custo_beneficio',
        'aplicacao',
        'base',
        'obs',
        'aplicacao_personalizada',
        'estabilidade',
        'sugestao_formulacao',
        'suporte_tecnico',
        'obs_olfativa'
    ];

    protected $casts = [
        'custo_beneficio' => 'boolean',
        'aplicacao' => 'boolean',
        'aplicacao_personalizada' => 'boolean',
        'estabilidade' => 'boolean',
        'sugestao_formulacao' => 'boolean',
        'suporte_tecnico' => 'boolean',
    ];
    
    function linha() 
    {
        return $this->belongsTo(Linha::class, 'linha_id');
    }

    function linhaTrashed() 
    {
        return $this->belongsTo(Linha::class, 'linha_id')->withTrashed();
    }

    function volume() 
    {
        return $this->belongsTo(Volume::class, 'volume_id');
    }

    function volumeTrashed() 
    {
        return $this->belongsTo(Volume::class, 'volume_id')->withTrashed();
    }
}
