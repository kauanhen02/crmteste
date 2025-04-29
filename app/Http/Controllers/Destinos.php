<?php

namespace App\Http\Controllers;

use App\Http\Requests\Destino\CriarDestinoRequest;
use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Destinos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_destino');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $destinos = Destino::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('destinos.table', [
                'destinos' => $destinos,
                'search' => $search,
            ]);
        }
        
        return view('destinos.lista', [
            'destinos' => $destinos,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_destino');
        
        return view('destinos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarDestinoRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_destino');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $destino = Destino::create($dados);
            $destino->criarLogCadastro($request->user());
        });

        return redirect()->route('destinos.index')->with('success', 'Destino criado com sucesso!');
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
    public function edit(Destino $destino)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_destino');
        return view('destinos.form', [
            'destino' => $destino
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarDestinoRequest $request, Destino $destino)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_destino');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $destino, $request)  {
            $destino->update($dados);
            $destino->criarLogEdicao($request->user());
        });

        return redirect()->route('destinos.edit', $destino)->with('success', 'Destino editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Destino $destino)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_destino');

        DB::transaction(function() use($destino, $request)  {
            $destino->delete();
            $destino->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Destino excluida com sucesso!'
        ]);
        // return redirect()->route('destinos.index')->with('success', 'Destino excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Destino $destino)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_destino');
        
        $destino = DB::transaction(function() use($destino, $request)  {
            $tipo = $destino->status ? 0 : 1;
            $destino->update(['status' => $tipo]);
            $destino->criarLogEdicao($request->user());
            return $destino;
        });

        $text = $destino->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Destino {$text} com sucesso!",
            'tipo' => $destino->status ? 'ativo' : 'desativado'
        ]);
    }
}
