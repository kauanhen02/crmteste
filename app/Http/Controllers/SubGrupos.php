<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubGrupoRequest\CriarSubGrupo;
use App\Models\SubGrupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubGrupos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_sub_grupo');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $subs = SubGrupo::pesquisaManyCampos($request, 'search', ['nome', 'sigla'])->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('sub_grupos.table', [
                'subs' => $subs,
                'search' => $search,
            ]);
        }
        
        return view('sub_grupos.lista', [
            'subs' => $subs,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_sub_grupo');

        return view('sub_grupos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarSubGrupo $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_sub_grupo');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $sub = SubGrupo::create($dados);
            $sub->criarLogCadastro($request->user());
        });

        return redirect()->route('sub_grupos.index')->with('success', 'Sub grupo criado com sucesso!');
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
    public function edit(SubGrupo $sub)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_sub_grupo');

        return view('sub_grupos.form', [
            'sub' => $sub,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarSubGrupo $request, SubGrupo $sub)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_sub_grupo');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $sub, $request)  {
            $sub->update($dados);
            $sub->criarLogEdicao($request->user());
        });

        return redirect()->route('sub_grupos.edit', $sub)->with('success', 'Sub grupo editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SubGrupo $sub)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_sub_grupo');

        DB::transaction(function() use($sub, $request)  {
            $sub->delete();
            $sub->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Sub grupo excluido com sucesso!'
        ]);
        // return redirect()->route('sub_grupos.index')->with('success', 'Sub grupo excluido com sucesso!');
    }

    function ativarDesativar(Request $request, SubGrupo $sub)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_sub_grupo');
        
        $sub = DB::transaction(function() use($sub, $request)  {
            $tipo = $sub->status ? 0 : 1;
            $sub->update(['status' => $tipo]);
            $sub->criarLogEdicao($request->user());
            return $sub;
        });

        $text = $sub->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Sub grupo {$text} com sucesso!",
            'tipo' => $sub->status ? 'ativo' : 'desativado'
        ]);
    }
}