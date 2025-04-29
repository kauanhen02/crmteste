<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinhaProduto\CriarLinhaProdutoRequest;
use App\Http\Requests\LinhaProduto\EditAtendimentoCategoriaRequest;
use App\Models\Atendimento;
use App\Models\Categoria;
use App\Models\Linha;
use App\Models\LinhaProduto;
use App\Models\TipoSolicitacao;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinhasProdutos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_linha_produto');
        $search_linha = $request->input('search_linha');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $linhas = LinhaProduto::where('atendimento_id', $atendimento->id)->with('linhaTrashed', 'volumeTrashed')->whereHas('linhaTrashed', function($q) use($search_linha){
            if(!empty($search_linha)){
                $q->where('nome', 'like', "%{$search_linha}%");
            }
        })->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('atendimentos.linhas.table', [
                'linhas' => $linhas,
                'search_linha' => $search_linha,
                'atendimento' => $atendimento,
            ]);
        }

        $tipo_solicitacoes = TipoSolicitacao::where('status', 1)->get();
        
        return view('atendimentos.linhas.lista', [
            'linhas' => $linhas,
            'search_linha' => $search_linha,
            'atendimento' => $atendimento,
            'tipo_solicitacoes' => $tipo_solicitacoes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EditAtendimentoCategoriaRequest $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_linha_produto');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $atendimento, $request) {
            $dados['exportacao'] = $request->boolean('exportacao');
            $atendimento->update($dados);
            $atendimento->criarLogEdicao($request->user());
        });

        $categorias = Categoria::where('status', 1)->get();
        $volumes = Volume::where('status', 1)->get();

        return view('atendimentos.linhas.form', [
            'atendimento' => $atendimento,
            'categorias' => $categorias,
            'volumes' => $volumes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarLinhaProdutoRequest $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_linha_produto');
        
        $dados = $request->validated();
        $linha = DB::transaction(function() use($dados, $request, $atendimento)  {
            $dados['custo_beneficio'] = $request->boolean('custo_beneficio');
            $dados['aplicacao'] = $request->boolean('aplicacao');
            $dados['aplicacao_personalizada'] = $request->boolean('aplicacao_personalizada');
            $dados['estabilidade'] = $request->boolean('estabilidade');
            $dados['sugestao_formulacao'] = $request->boolean('sugestao_formulacao');
            $dados['suporte_tecnico'] = $request->boolean('suporte_tecnico');
            $linha = $atendimento->linhas()->create($dados);
            $linha->criarLogCadastro($request->user());
            return $linha;
        });

        return response()->json([
            'text' => 'Linha de produto adicionado com sucesso!',
            'title' => 'Linha de produto',
            'text' => 'Linha de produto adicionado com sucesso!',
            'icon' => 'success',
        ]);
        // return redirect()->route('linhasProdutos.index', $atendimento)->with('success', 'Linha de produto adicionado com sucesso!');
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
    public function edit(Request $request, Atendimento $atendimento, LinhaProduto $linha)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_linha_produto');

        $categorias = Categoria::where('status', 1)->get();
        $volumes = Volume::where('status', 1)->get();

        return view('atendimentos.linhas.form', [
            'atendimento' => $atendimento,
            'linha' => $linha,
            'volumes' => $volumes,
            'categorias' => $categorias
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarLinhaProdutoRequest $request, Atendimento $atendimento, LinhaProduto $linha)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_linha_produto');
        abort_unless($linha->atendimento_id === $atendimento->id, 403);

        $dados = $request->validated();
        
        DB::transaction(function() use($dados, $linha, $request)  {
            $dados['custo_beneficio'] = $request->boolean('custo_beneficio');
            $dados['aplicacao'] = $request->boolean('aplicacao');
            $dados['aplicacao_personalizada'] = $request->boolean('aplicacao_personalizada');
            $dados['estabilidade'] = $request->boolean('estabilidade');
            $dados['sugestao_formulacao'] = $request->boolean('sugestao_formulacao');
            $dados['suporte_tecnico'] = $request->boolean('suporte_tecnico');
            $linha->update($dados);
            $linha->criarLogEdicao($request->user());
        });

        return response()->json([
            'text' => 'Linha de produto editado com sucesso!',
            'title' => 'Linha de produto',
            'text' => 'Linha de produto editado com sucesso!',
            'icon' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Atendimento $atendimento, LinhaProduto $linha)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_linha_produto');
        abort_unless($linha->atendimento_id === $atendimento->id, 403);

        DB::transaction(function() use($linha, $request)  {
            $linha->delete();
            $linha->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Linha de produto excluida com sucesso!'
        ]);
        // return redirect()->route('atendimentos.index')->with('success', 'Atendimento excluido com sucesso!');
    }
}
