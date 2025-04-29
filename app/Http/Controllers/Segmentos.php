<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegmentosRequest\CriarSegmentoRequest;
use App\Models\Segmento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Segmentos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_segmento');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $segmentos = Segmento::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('segmentos.table', [
                'segmentos' => $segmentos,
                'search' => $search,
            ]);
        }
        
        return view('segmentos.lista', [
            'segmentos' => $segmentos,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_segmento');

        return view('segmentos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarSegmentoRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_segmento');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $segmento = Segmento::create($dados);
            $segmento->criarLogCadastro($request->user());
        });

        return redirect()->route('segmentos.index')->with('success', 'Segmento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Segmento $segmento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_segmento');

        return view('segmentos.form', [
            'segmento' => $segmento,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarSegmentoRequest $request, Segmento $segmento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_segmento');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $segmento, $request)  {
            $segmento->update($dados);
            $segmento->criarLogEdicao($request->user());
        });

        return redirect()->route('segmentos.edit', $segmento)->with('success', 'Segmento editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Segmento $segmento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_segmento');

        DB::transaction(function() use($segmento, $request)  {
            $segmento->delete();
            $segmento->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Segmento excluida com sucesso!'
        ]);
        // return redirect()->route('segmentos.index')->with('success', 'Segmento excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Segmento $segmento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_segmento');
        
        $segmento = DB::transaction(function() use($segmento, $request)  {
            $tipo = $segmento->status ? 0 : 1;
            $segmento->update(['status' => $tipo]);
            $segmento->criarLogEdicao($request->user());
            return $segmento;
        });

        $text = $segmento->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Segmento {$text} com sucesso!",
            'tipo' => $segmento->status ? 'ativo' : 'desativado'
        ]);
    }
}
