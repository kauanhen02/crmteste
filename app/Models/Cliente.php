<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes, PesquisaPadraoSupport, RegistroLog;

    protected $table = 'clientes';

    protected $fillable = [
        'carteira_id',
        'segmento_id',
        'forma_atuacao_id',
        'status_lgpd_id',
        'nome',
        'razao_social',
        'cnpj',
        'telefone',
        'email',
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    function carteira()
    {
       return $this->belongsTo(Carteira::class, 'carteira_id');
    }
    
    function carteiraTrashed()
    {
        return $this->belongsTo(Carteira::class, 'carteira_id')->withTrashed();
    }

    function segmento()
    {
       return $this->belongsTo(Segmento::class, 'segmento_id');
    }
    
    function segmentoTrashed()
    {
        return $this->belongsTo(Segmento::class, 'segmento_id')->withTrashed();
    }

    function formaAtuacao()
    {
       return $this->belongsTo(FormaAtuacao::class, 'forma_atuacao_id');
    }
    
    function formaAtuacaoTrashed()
    {
        return $this->belongsTo(FormaAtuacao::class, 'forma_atuacao_id')->withTrashed();
    }

    function status()
    {
       return $this->belongsTo(StatuLGPD::class, 'status_lgpd_id');
    }
    
    function statusTrashed()
    {
        return $this->belongsTo(StatuLGPD::class, 'status_lgpd_id')->withTrashed();
    }
}
