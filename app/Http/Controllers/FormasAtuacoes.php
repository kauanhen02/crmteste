<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormaAtuacaoRequest\CriarFormaAtuacao;
use App\Models\FormaAtuacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormasAtuacoes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_forma_atuacao');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $atuacaos = FormaAtuacao::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('formas_atuacoes.table', [
                'atuacoes' => $atuacaos,
                'search' => $search,
            ]);
        }
        
        return view('formas_atuacoes.lista', [
            'atuacoes' => $atuacaos,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_forma_atuacao');

        return view('formas_atuacoes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarFormaAtuacao $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_forma_atuacao');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $atuacao = FormaAtuacao::create($dados);
            $atuacao->criarLogCadastro($request->user());
        });

        return redirect()->route('formas_atuacoes.index')->with('success', 'Forma de Atuação criado com sucesso!');
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
    public function edit(FormaAtuacao $atuacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_forma_atuacao');

        return view('formas_atuacoes.form', [
            'atuacao' => $atuacao,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarFormaAtuacao $request, FormaAtuacao $atuacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_forma_atuacao');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $atuacao, $request)  {
            $atuacao->update($dados);
            $atuacao->criarLogEdicao($request->user());
        });

        return redirect()->route('formas_atuacoes.edit', $atuacao)->with('success', 'Forma de Atuação editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, FormaAtuacao $atuacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_forma_atuacao');

        DB::transaction(function() use($atuacao, $request)  {
            $atuacao->delete();
            $atuacao->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Forma de Atuação excluida com sucesso!'
        ]);
        // return redirect()->route('formas_atuacoes.index')->with('success', 'Forma de Atuação excluido com sucesso!');
    }

    function ativarDesativar(Request $request, FormaAtuacao $atuacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_forma_atuacao');
        
        $atuacao = DB::transaction(function() use($atuacao, $request)  {
            $tipo = $atuacao->status ? 0 : 1;
            $atuacao->update(['status' => $tipo]);
            $atuacao->criarLogEdicao($request->user());
            return $atuacao;
        });

        $text = $atuacao->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Forma de Atuação {$text} com sucesso!",
            'tipo' => $atuacao->status ? 'ativo' : 'desativado'
        ]);
    }
}
