<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'usuario_id',
        'usuario_type',
        'descricao',
        'dados',
        'registro_type',
        'registro_id',
    ];

    protected $casts = [
        'dados' => 'array',
    ];

    protected $hidden = [
        'dados',
    ];

    public function usuario()
    {
        return $this->morphTo();
    }

    public function registro()
    {
        return $this->morphTo();
    }
}
