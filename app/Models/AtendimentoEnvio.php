<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtendimentoEnvio extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'atendimento_has_envios'; // Nome da tabela

    protected $fillable = [
        'atendimento_id',
        'destino_id',
        'envio_id',
        'contato',
        'cidade',
        'estado',
        'rua',
        'numero',
        'bairro',
        'complemento',
        'cep',
        'obs'
    ];

    function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id');
    }

    function destinoTrashed()
    {
        return $this->belongsTo(Destino::class, 'destino_id')->withTrashed();
    }

    function envio()
    {
        return $this->belongsTo(Envio::class, 'envio_id');
    }

    function envioTrashed()
    {
        return $this->belongsTo(Envio::class, 'envio_id')->withTrashed();
    }
}
