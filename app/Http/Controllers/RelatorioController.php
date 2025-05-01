<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function dados()
    {
        $dados = [
            [ "cliente" => "João", "valor" => 150.75 ],
            [ "cliente" => "Maria", "valor" => 200.50 ],
        ];

        return response()->json($dados);
    }
}
