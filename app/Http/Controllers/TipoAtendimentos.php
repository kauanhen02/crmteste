<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoAtendimento\CriarTipoAtendimentoRequest;
use App\Models\TipoAtendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoAtendimentos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_tipo_atendimento');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $atendimentos = TipoAtendimento::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('tipo_atendimentos.table', [
                'atendimentos' => $atendimentos,
                'search' => $search,
            ]);
        }
        
        return view('tipo_atendimentos.lista', [
            'atendimentos' => $atendimentos,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_tipo_atendimento');

        return view('tipo_atendimentos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarTipoAtendimentoRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_tipo_atendimento');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $atendimento = TipoAtendimento::create($dados);
            $atendimento->criarLogCadastro($request->user());
        });

        return redirect()->route('tipoAtendimentos.index')->with('success', 'Tipo de atendimento criado com sucesso!');
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
    public function edit(TipoAtendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_tipo_atendimento');

        return view('tipo_atendimentos.form', [
            'atendimento' => $atendimento,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarTipoAtendimentoRequest $request, TipoAtendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_tipo_atendimento');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $atendimento, $request)  {
            $atendimento->update($dados);
            $atendimento->criarLogEdicao($request->user());
        });

        return redirect()->route('tipoAtendimentos.edit', $atendimento)->with('success', 'Tipo de atendimento editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TipoAtendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_tipo_atendimento');

        DB::transaction(function() use($atendimento, $request)  {
            $atendimento->delete();
            $atendimento->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Tipo de atendimento excluida com sucesso!'
        ]);
        // return redirect()->route('tipoAtendimentos.index')->with('success', 'Tipo de atendimento excluido com sucesso!');
    }

    function ativarDesativar(Request $request, TipoAtendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_tipo_atendimento');
        
        $atendimento = DB::transaction(function() use($atendimento, $request)  {
            $tipo = $atendimento->status ? 0 : 1;
            $atendimento->update(['status' => $tipo]);
            $atendimento->criarLogEdicao($request->user());
            return $atendimento;
        });

        $text = $atendimento->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "TipoAtendimento {$text} com sucesso!",
            'tipo' => $atendimento->status ? 'ativo' : 'desativado'
        ]);
    }
}
