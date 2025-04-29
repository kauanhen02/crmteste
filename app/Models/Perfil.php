<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'perfis'; // Nome da tabela

    protected $fillable = [
        'descricao'
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'perfil_id');
    }

    function habilidades()
    {
        return $this->belongsToMany(Habilidade::class, 'perfis_has_habilidades', 'perfil_id', 'habilidade_id');
    }
}
