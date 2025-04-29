<?php

namespace App\Http\Controllers;

use App\Http\Requests\Envio\CriarEnvioRequest;
use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Envios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_envio');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $envios = Envio::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('envios.table', [
                'envios' => $envios,
                'search' => $search,
            ]);
        }
        
        return view('envios.lista', [
            'envios' => $envios,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_envio');
        
        return view('envios.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarEnvioRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_envio');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $envio = Envio::create($dados);
            $envio->criarLogCadastro($request->user());
        });

        return redirect()->route('envios.index')->with('success', 'Envio criado com sucesso!');
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
    public function edit(Envio $envio)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_envio');
        return view('envios.form', [
            'envio' => $envio
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarEnvioRequest $request, Envio $envio)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_envio');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $envio, $request)  {
            $envio->update($dados);
            $envio->criarLogEdicao($request->user());
        });

        return redirect()->route('envios.edit', $envio)->with('success', 'Envio editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Envio $envio)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_envio');

        DB::transaction(function() use($envio, $request)  {
            $envio->delete();
            $envio->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Envio excluida com sucesso!'
        ]);
        // return redirect()->route('envios.index')->with('success', 'Envio excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Envio $envio)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_envio');
        
        $envio = DB::transaction(function() use($envio, $request)  {
            $tipo = $envio->status ? 0 : 1;
            $envio->update(['status' => $tipo]);
            $envio->criarLogEdicao($request->user());
            return $envio;
        });

        $text = $envio->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Envio {$text} com sucesso!",
            'tipo' => $envio->status ? 'ativo' : 'desativado'
        ]);
    }
}