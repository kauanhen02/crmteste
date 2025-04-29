<?php

namespace App\Http\Controllers;

use App\Http\Requests\Linha\CriarLinhaRequest;
use App\Models\Categoria;
use App\Models\Linha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Linhas extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_linha');
        $search = $request->input('search');
        $categoria_id = $request->input('categoria_id');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $linhas = Linha::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')
            ->pesquisaPadrao($request, 'categoria_id', 'categoria_id', 'equals')
            ->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('linhas.table', [
                'linhas' => $linhas,
                'search' => $search,
                'categoria_id' => $categoria_id,
            ]);
        }

        $categorias = Categoria::where('status', 1)->get();
        
        return view('linhas.lista', [
            'linhas' => $linhas,
            'search' => $search,
            'categoria_id' => $categoria_id,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_linha');

        $categorias = Categoria::where('status', 1)->get();

        return view('linhas.form', [
            'categorias' => $categorias
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarLinhaRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_linha');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $linha = Linha::create($dados);
            $linha->criarLogCadastro($request->user());
        });

        return redirect()->route('linhas.index')->with('success', 'Linha criado com sucesso!');
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
    public function edit(Linha $linha)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_linha');

        $categorias = Categoria::where('status', 1)->get();

        return view('linhas.form', [
            'linha' => $linha,
            'categorias' => $categorias
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarLinhaRequest $request, Linha $linha)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_linha');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $linha, $request)  {
            $linha->update($dados);
            $linha->criarLogEdicao($request->user());
        });

        return redirect()->route('linhas.edit', $linha)->with('success', 'Linha editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Linha $linha)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_linha');

        DB::transaction(function() use($linha, $request)  {
            $linha->delete();
            $linha->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Linha excluida com sucesso!'
        ]);
        // return redirect()->route('linhas.index')->with('success', 'Linha excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Linha $linha)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_linha');
        
        $linha = DB::transaction(function() use($linha, $request)  {
            $tipo = $linha->status ? 0 : 1;
            $linha->update(['status' => $tipo]);
            $linha->criarLogEdicao($request->user());
            return $linha;
        });

        $text = $linha->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Linha {$text} com sucesso!",
            'tipo' => $linha->status ? 'ativo' : 'desativado'
        ]);
    }

    function getLinhasCategoria(Request $request)
    {

        $linhas = Linha::select(['id', 'nome'])->where('categoria_id', $request->categoria_id)->where("status", 1)->get();
        return response()->json([
            'linhas' => $linhas
        ]);
    }
}
