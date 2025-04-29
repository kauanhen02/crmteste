<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeloImpressao\CriarModeloImpressaoRequest;
use App\Models\ModeloImpressao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelosImpressoes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_modelo_impressao');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $modelos = ModeloImpressao::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')
            ->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('modelos.impressao.table', [
                'modelos' => $modelos,
                'search' => $search
            ]);
        }

        
        return view('modelos.impressao.lista', [
            'modelos' => $modelos,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_modelo_impressao');
        return view('modelos.impressao.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarModeloImpressaoRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_modelo_impressao');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $modelo = ModeloImpressao::create($dados);
            $modelo->criarLogCadastro($request->user());
        });

        return redirect()->route('modelosImpressao.index')->with('success', 'Modelo impressão criado com sucesso!');
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
    public function edit(ModeloImpressao $modelo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_modelo_impressao');

        return view('modelos.impressao.form', [
            'modelo' => $modelo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarModeloImpressaoRequest $request, ModeloImpressao $modelo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_modelo_impressao');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $modelo, $request)  {
            $modelo->update($dados);
            $modelo->criarLogEdicao($request->user());
        });

        return redirect()->route('modelosImpressao.edit', $modelo)->with('success', 'Modelo impressão editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ModeloImpressao $modelo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_modelo_impressao');

        DB::transaction(function() use($modelo, $request)  {
            $modelo->delete();
            $modelo->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Modelo impressão excluida com sucesso!'
        ]);
        // return redirect()->route('modelos.impressao.index')->with('success', 'Modelo impressão excluido com sucesso!');
    }

    function ativarDesativar(Request $request, ModeloImpressao $modelo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_modelo_impressao');
        
        $modelo = DB::transaction(function() use($modelo, $request)  {
            $tipo = $modelo->status ? 0 : 1;
            $modelo->update(['status' => $tipo]);
            $modelo->criarLogEdicao($request->user());
            return $modelo;
        });

        $text = $modelo->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "ModeloImpressao {$text} com sucesso!",
            'tipo' => $modelo->status ? 'ativo' : 'desativado'
        ]);
    }
}
