<?php

namespace App\Http\Controllers;

use App\Http\Requests\Atendimentos\CriarAtendimentoEnviosRequest;
use App\Models\Atendimento;
use App\Models\AtendimentoEnvio;
use App\Models\Destino;
use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtendimentoEnvios extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_atendimento_envio');
        $search_destino = $request->input('search_destino');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $envios = AtendimentoEnvio::where('atendimento_id', $atendimento->id)->with('destinoTrashed', 'envioTrashed')->whereHas('destinoTrashed', function($q) use($search_destino){
            if(!empty($search_destino)){
                $q->where('nome', 'like', "%{$search_destino}%");
            }
        })->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('atendimentos.envios.table', [
                'envios' => $envios,
                'search_destino' => $search_destino,
                'atendimento' => $atendimento,
            ]);
        }
        
        return view('atendimentos.envios.lista', [
            'envios' => $envios,
            'search_destino' => $search_destino,
            'atendimento' => $atendimento,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_atendimento_envio');

        $envios = Envio::where('status', 1)->get();
        $destinos = Destino::where('status', 1)->get();

        return view('atendimentos.envios.form', [
            'atendimento' => $atendimento,
            'envios' => $envios,
            'destinos' => $destinos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarAtendimentoEnviosRequest $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_atendimento_envio');
        
        $dados = $request->validated();
        $envio = DB::transaction(function() use($dados, $request, $atendimento)  {
            $dados['custo_beneficio'] = $request->boolean('custo_beneficio');
            $dados['aplicacao'] = $request->boolean('aplicacao');
            $dados['aplicacao_personalizada'] = $request->boolean('aplicacao_personalizada');
            $dados['estabilidade'] = $request->boolean('estabilidade');
            $dados['sugestao_formulacao'] = $request->boolean('sugestao_formulacao');
            $dados['suporte_tecnico'] = $request->boolean('suporte_tecnico');
            $envio = $atendimento->envios()->create($dados);
            $envio->criarLogCadastro($request->user());
            return $envio;
        });

        return response()->json([
            'text' => 'Envio adicionado com sucesso!',
            'title' => 'Envio',
            'text' => 'Envio adicionado com sucesso!',
            'icon' => 'success',
        ]);
        // return redirect()->route('enviosProdutos.index', $atendimento)->with('success', 'Envio adicionado com sucesso!');
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
    public function edit(Request $request, Atendimento $atendimento, AtendimentoEnvio $envio)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento_envio');

        $envios = Envio::where('status', 1)->get();
        $destinos = Destino::where('status', 1)->get();

        return view('atendimentos.envios.form', [
            'atendimento' => $atendimento,
            'envio' => $envio,
            'destinos' => $destinos,
            'envios' => $envios
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarAtendimentoEnviosRequest $request, Atendimento $atendimento, AtendimentoEnvio $envio)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento_envio');
        abort_unless($envio->atendimento_id === $atendimento->id, 403);

        $dados = $request->validated();
        
        DB::transaction(function() use($dados, $envio, $request)  {
            $envio->update($dados);
            $envio->criarLogEdicao($request->user());
        });

        return response()->json([
            'text' => 'Envio editado com sucesso!',
            'title' => 'Envio',
            'text' => 'Envio editado com sucesso!',
            'icon' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Atendimento $atendimento, AtendimentoEnvio $envio)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_atendimento_envio');
        abort_unless($envio->atendimento_id === $atendimento->id, 403);

        DB::transaction(function() use($envio, $request)  {
            $envio->delete();
            $envio->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Envio excluida com sucesso!'
        ]);
        // return redirect()->route('atendimentos.index')->with('success', 'Atendimento excluido com sucesso!');
    }
}
