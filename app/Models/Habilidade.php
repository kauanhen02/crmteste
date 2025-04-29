<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidade extends Model
{
    protected $table = "habilidades";

    protected $fillable = [
        'nome',
        'grupo_habilidade',
        'nome_unico'
    ];

    function perfis()
    {        
        return $this->belongsToMany(Perfil::class, 'perfis_has_habilidades', 'habilidade_id', 'perfil_id');
    }
}
