<?php

namespace App\Http\Controllers;

use App\Http\Requests\GruposRequest\CriarGrupo;
use App\Models\Grupo;
use App\Models\SubGrupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Grupos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_grupo');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $grupos = Grupo::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('grupos.table', [
                'grupos' => $grupos,
                'search' => $search,
            ]);
        }
        
        return view('grupos.lista', [
            'grupos' => $grupos,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_grupo');
        
        return view('grupos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarGrupo $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_grupo');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $grupo = Grupo::create($dados);
            $grupo->criarLogCadastro($request->user());
        });

        return redirect()->route('grupos.index')->with('success', 'Grupo criado com sucesso!');
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
    public function edit(Grupo $grupo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_grupo');
        return view('grupos.form', [
            'grupo' => $grupo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarGrupo $request, Grupo $grupo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_grupo');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $grupo, $request)  {
            $grupo->update($dados);
            $grupo->criarLogEdicao($request->user());
        });

        return redirect()->route('grupos.edit', $grupo)->with('success', 'Grupo editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Grupo $grupo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_grupo');

        DB::transaction(function() use($grupo, $request)  {
            $grupo->delete();
            $grupo->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Grupo excluida com sucesso!'
        ]);
        // return redirect()->route('grupos.index')->with('success', 'Grupo excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Grupo $grupo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_grupo');
        
        $grupo = DB::transaction(function() use($grupo, $request)  {
            $tipo = $grupo->status ? 0 : 1;
            $grupo->update(['status' => $tipo]);
            $grupo->criarLogEdicao($request->user());
            return $grupo;
        });

        $text = $grupo->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Grupo {$text} com sucesso!",
            'tipo' => $grupo->status ? 'ativo' : 'desativado'
        ]);
    }
}
