<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarteriaRequest\CriarCarteira;
use App\Models\Carteira;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Carteiras extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_carteira');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $carteiras = Carteira::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('carteiras.table', [
                'carteiras' => $carteiras,
                'search' => $search,
            ]);
        }
        
        return view('carteiras.lista', [
            'carteiras' => $carteiras,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_carteira');

        return view('carteiras.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarCarteira $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_carteira');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $carteira = Carteira::create($dados);
            $carteira->criarLogCadastro($request->user());
        });

        return redirect()->route('carteiras.index')->with('success', 'Carteira criado com sucesso!');
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
    public function edit(Carteira $carteira)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_carteira');

        return view('carteiras.form', [
            'carteira' => $carteira,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarCarteira $request, Carteira $carteira)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_carteira');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $carteira, $request)  {
            $carteira->update($dados);
            $carteira->criarLogEdicao($request->user());
        });

        return redirect()->route('carteiras.edit', $carteira)->with('success', 'Carteira editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Carteira $carteira)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_carteira');

        DB::transaction(function() use($carteira, $request)  {
            $carteira->delete();
            $carteira->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Carteira excluida com sucesso!'
        ]);
        // return redirect()->route('carteiras.index')->with('success', 'Carteira excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Carteira $carteira)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_carteira');
        
        $carteira = DB::transaction(function() use($carteira, $request)  {
            $tipo = $carteira->status ? 0 : 1;
            $carteira->update(['status' => $tipo]);
            $carteira->criarLogEdicao($request->user());
            return $carteira;
        });

        $text = $carteira->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Carteira {$text} com sucesso!",
            'tipo' => $carteira->status ? 'ativo' : 'desativado'
        ]);
    }
}
