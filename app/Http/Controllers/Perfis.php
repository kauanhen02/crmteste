<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilRequest\CriarPerfilRequest;
use App\Http\Requests\PerfilRequest\HabilidadeRequest;
use App\Models\Habilidade;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Perfis extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_perfil');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $perfis = Perfil::pesquisaPadrao($request, 'search', 'descricao')->paginate(10);

        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('perfis.table', [
                'perfis' => $perfis,
                'search' => $search,
            ]);
        }
        
        return view('perfis.lista', [
            'perfis' => $perfis,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_perfil');

        $perfis = Perfil::get();
        return view('perfis.form', [
            'perfis' => $perfis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarPerfilRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_perfil');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $request)  {
            $perfil = Perfil::create($dados);
            $perfil->criarLogCadastro($request->user());
        });

        return redirect()->route('perfis.index')->with('success', 'Perfil criado com sucesso!');
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
    public function edit(Perfil $perfil)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_perfil');
        
        return view('perfis.form', [
            'perfil' => $perfil,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarPerfilRequest $request, Perfil $perfil)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_perfil');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $perfil, $request)  {
            $perfil->update($dados);
            $perfil->criarLogEdicao($request->user());
        });

        return redirect()->route('perfis.edit', $perfil)->with('success', 'Perfil editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Perfil $perfil)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_perfil');

        DB::transaction(function() use($perfil, $request)  {
            $perfil->delete();
            $perfil->criarLogExclusao($request->user());
        });

        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        // $perfis = Perfil::pesquisaPadrao($request, 'search', 'descricao')->paginate(1);

        // return view('perfis.table', [
        //     'perfis' => $perfis,
        //     'search' => $search,
        // ]);

        return response()->json([
            'text' => "Perfil excluido com sucesso!"
        ]);

        // return redirect()->route('perfis.index')->with('success', 'Perfil excluido com sucesso!');
    }

    function habilidades(Request $request, Perfil $perfil)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_habilidade_perfil');
        $habilidade = Habilidade::orderBy('grupo_habilidade', 'ASC')->orderBy('nome_unico', "ASC")->with('perfis')->get();
            
        $habilidades = [];
        foreach ($habilidade as $key => $value) {
            if(!isset($habilidades[$value->grupo_habilidade])){
                $habilidades[$value->grupo_habilidade] = [
                    'grupo' => $value->grupo_habilidade
                ];
            }

            $habilidades[$value->grupo_habilidade]['habilidades'][] = [
                'id' => $value->id,
                'nome' => $value->nome,
                'nome_unico' => $value->nome_unico,
                'ativo' => $value->perfis->contains('id', $perfil->id)
            ];
            
        }

        return view('perfis.habilidades', [
            'perfil' => $perfil,
            'habilidades' => $habilidades,
        ]);
    }

    function habilidadesStore(HabilidadeRequest $request, Perfil $perfil)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_habilidade_perfil');
        $dados = $request->validated();

        DB::transaction(function() use($dados, $perfil){
            $perfil->habilidades()->detach();
            if(isset($dados['habilidades']) && count($dados['habilidades']) > 0){
                $perfil->habilidades()->attach($dados['habilidades']);
            }
        });

        return redirect()->route('perfis.habilidades', [$perfil])->with('success', 'Habilidades editadas com sucesso!');
    }
}
