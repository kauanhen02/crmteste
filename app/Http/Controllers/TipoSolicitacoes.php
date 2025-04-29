<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoSoliciticao\CriarTipoSoliciticaoRequest;
use App\Models\TipoSolicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoSolicitacoes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_tipo_solicitacao');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $solicitacaos = TipoSolicitacao::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('tipo_solicitacoes.table', [
                'solicitacoes' => $solicitacaos,
                'search' => $search,
            ]);
        }
        
        return view('tipo_solicitacoes.lista', [
            'solicitacoes' => $solicitacaos,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_tipo_solicitacao');

        return view('tipo_solicitacoes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarTipoSoliciticaoRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_tipo_solicitacao');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $solicitacao = TipoSolicitacao::create($dados);
            $solicitacao->criarLogCadastro($request->user());
        });

        return redirect()->route('tipoSolicitacoes.index')->with('success', 'Tipo de solicitação criado com sucesso!');
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
    public function edit(TipoSolicitacao $solicitacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_tipo_solicitacao');

        return view('tipo_solicitacoes.form', [
            'solicitacao' => $solicitacao,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarTipoSoliciticaoRequest $request, TipoSolicitacao $solicitacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_tipo_solicitacao');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $solicitacao, $request)  {
            $solicitacao->update($dados);
            $solicitacao->criarLogEdicao($request->user());
        });

        return redirect()->route('tipoSolicitacoes.edit', $solicitacao)->with('success', 'Tipo de solicitação editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TipoSolicitacao $solicitacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_tipo_solicitacao');

        DB::transaction(function() use($solicitacao, $request)  {
            $solicitacao->delete();
            $solicitacao->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Tipo de solicitação excluida com sucesso!'
        ]);
        // return redirect()->route('tipoSolicitacoes.index')->with('success', 'Tipo de solicitação excluido com sucesso!');
    }

    function ativarDesativar(Request $request, TipoSolicitacao $solicitacao)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_tipo_solicitacao');
        
        $solicitacao = DB::transaction(function() use($solicitacao, $request)  {
            $tipo = $solicitacao->status ? 0 : 1;
            $solicitacao->update(['status' => $tipo]);
            $solicitacao->criarLogEdicao($request->user());
            return $solicitacao;
        });

        $text = $solicitacao->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "TipoSolicitacao {$text} com sucesso!",
            'tipo' => $solicitacao->status ? 'ativo' : 'desativado'
        ]);
    }
}
