<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

trait PesquisaPadraoSupport {
    /*
        Request $request
        String $input,
        string $campo
    */
    function scopePesquisaPadrao(Builder $query, $request, string $input, string $campo, $tipo = 'like'): Builder
    {
        if(isset($request->{$input}) && !empty($request->input($input))){
            if($tipo == 'like'){
                $query->where($campo, 'like', "%{$request->input($input)}%");
            }else{
                $query->where($campo, $request->input($input));
            }
        }

        return $query;
    }
    
    function scopePesquisaStatus(Builder $query, $request, string $input, string $campo): Builder
    {
        if(isset($request->{$input}) && !empty($request->input($input))){
            $valor = ($request->{$input} == "ativo") ? 1 : 0; 
            $query->where($campo, $valor);
        }

        return $query;
    }
    
    function scopePesquisaManyCampos(Builder $query, $request, string $input, array $campo = []): Builder
    {
        if(isset($request->{$input}) && !empty($request->input($input))){
            $filtro = $request->{$input};
            $query->where(function($q) use($filtro, $campo){
                foreach ($campo as $key => $value) {
                    if($key == 0){
                        $q->where($value, 'like', "%{$filtro}%");
                    }else{
                        $q->orWhere($value, 'like', "%{$filtro}%");
                    }
                }
            });
        }

        return $query;
    }
}