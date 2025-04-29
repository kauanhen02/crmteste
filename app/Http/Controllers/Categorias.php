<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categoria\CriarCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Categorias extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_categoria');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $categorias = Categoria::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('categorias.table', [
                'categorias' => $categorias,
                'search' => $search,
            ]);
        }
        
        return view('categorias.lista', [
            'categorias' => $categorias,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_categoria');

        return view('categorias.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarCategoriaRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_categoria');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $categoria = Categoria::create($dados);
            $categoria->criarLogCadastro($request->user());
        });

        return redirect()->route('categorias.index')->with('success', 'Categoria criado com sucesso!');
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
    public function edit(Categoria $categoria)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_categoria');

        return view('categorias.form', [
            'categoria' => $categoria,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarCategoriaRequest $request, Categoria $categoria)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_categoria');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $categoria, $request)  {
            $categoria->update($dados);
            $categoria->criarLogEdicao($request->user());
        });

        return redirect()->route('categorias.edit', $categoria)->with('success', 'Categoria editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Categoria $categoria)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_categoria');

        DB::transaction(function() use($categoria, $request)  {
            $categoria->delete();
            $categoria->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Categoria excluida com sucesso!'
        ]);
        // return redirect()->route('categorias.index')->with('success', 'Categoria excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Categoria $categoria)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_categoria');
        
        $categoria = DB::transaction(function() use($categoria, $request)  {
            $tipo = $categoria->status ? 0 : 1;
            $categoria->update(['status' => $tipo]);
            $categoria->criarLogEdicao($request->user());
            return $categoria;
        });

        $text = $categoria->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Categoria {$text} com sucesso!",
            'tipo' => $categoria->status ? 'ativo' : 'desativado'
        ]);
    }
}
