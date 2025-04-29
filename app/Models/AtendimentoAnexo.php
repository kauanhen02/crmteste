<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtendimentoAnexo extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'atendimento_has_anexos'; // Nome da tabela

    protected $fillable = [
        'atendimento_id',
        'descricao',
        'diretorio'
    ];
}
