<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoServicoRequest\CriarProdutoServico;
use App\Models\Grupo;
use App\Models\ProdutoServico;
use App\Models\SubGrupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutosServicos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_produto_servico');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $produto_servicos = ProdutoServico::pesquisaManyCampos($request, 'search', ['descricao', 'cod'])
            ->pesquisaStatus($request, 'status', 'status')
            ->pesquisaPadrao($request, 'grupo_id', 'grupo_id', 'normal')
            ->pesquisaPadrao($request, 'sub_grupo_id', 'sub_grupo_id', 'normal')
            ->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('produtos_servicos.table', [
                'produtos_servicos' => $produto_servicos,
                'search' => $search,
            ]);
        }
        
        $grupos = Grupo::where('status', 1)->get();
        $sub_grupos = SubGrupo::where('status', 1)->get();
        
        return view('produtos_servicos.lista', [
            'produtos_servicos' => $produto_servicos,
            'search' => $search,
            'grupos' => $grupos,
            'sub_grupos' => $sub_grupos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_produto_servico');

        $grupos = Grupo::where('status', 1)->get();
        $sub_grupos = SubGrupo::where('status', 1)->get();

        return view('produtos_servicos.form', [
            'grupos' => $grupos,
            'sub_grupos' => $sub_grupos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarProdutoServico $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_produto_servico');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $dados['custo_medio_ponderado'] = str_replace(['.', ','], ['','.'],$dados['custo_medio_ponderado']);
            $produto_servico = ProdutoServico::create($dados);
            $produto_servico->criarLogCadastro($request->user());
        });

        return redirect()->route('produtos_servicos.index')->with('success', 'Produto/Serviço criado com sucesso!');
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
    public function edit(ProdutoServico $produto_servico)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_produto_servico');
        
        $grupos = Grupo::where('status', 1)->get();
        $sub_grupos = SubGrupo::where('status', 1)->get();

        return view('produtos_servicos.form', [
            'produto_servico' => $produto_servico,
            'grupos' => $grupos,
            'sub_grupos' => $sub_grupos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarProdutoServico $request, ProdutoServico $produto_servico)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_produto_servico');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $produto_servico, $request)  {
            $dados['custo_medio_ponderado'] = str_replace(['.', ','], ['','.'],$dados['custo_medio_ponderado']);
            $produto_servico->update($dados);
            $produto_servico->criarLogEdicao($request->user());
        });

        return redirect()->route('produtos_servicos.edit', $produto_servico)->with('success', 'Produto/Serviço editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ProdutoServico $produto_servico)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_produto_servico');

        DB::transaction(function() use($produto_servico, $request)  {
            $produto_servico->delete();
            $produto_servico->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Produto/Serviço excluida com sucesso!'
        ]);
        // return redirect()->route('produtos_servicos.index')->with('success', 'Produto/Serviço excluido com sucesso!');
    }

    function ativarDesativar(Request $request, ProdutoServico $produto_servico)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_produto_servico');
        
        $produto_servico = DB::transaction(function() use($produto_servico, $request)  {
            $tipo = $produto_servico->status ? 0 : 1;
            $produto_servico->update(['status' => $tipo]);
            $produto_servico->criarLogEdicao($request->user());
            return $produto_servico;
        });

        $text = $produto_servico->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Produto/Serviço {$text} com sucesso!",
            'tipo' => $produto_servico->status ? 'ativo' : 'desativado'
        ]);
    }
}