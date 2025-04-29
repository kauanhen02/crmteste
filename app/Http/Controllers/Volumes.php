<?php

namespace App\Http\Controllers;

use App\Http\Requests\Volume\CriarVolumeRequest;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Volumes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_volume');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $volumes = Volume::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('volumes.table', [
                'volumes' => $volumes,
                'search' => $search,
            ]);
        }
        
        return view('volumes.lista', [
            'volumes' => $volumes,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_volume');

        return view('volumes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarVolumeRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_volume');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $volume = Volume::create($dados);
            $volume->criarLogCadastro($request->user());
        });

        return redirect()->route('volumes.index')->with('success', 'Volume criado com sucesso!');
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
    public function edit(Volume $volume)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_volume');

        return view('volumes.form', [
            'volume' => $volume,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarVolumeRequest $request, Volume $volume)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_volume');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $volume, $request)  {
            $volume->update($dados);
            $volume->criarLogEdicao($request->user());
        });

        return redirect()->route('volumes.edit', $volume)->with('success', 'Volume editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Volume $volume)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_volume');

        DB::transaction(function() use($volume, $request)  {
            $volume->delete();
            $volume->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Volume excluida com sucesso!'
        ]);
        // return redirect()->route('volumes.index')->with('success', 'Volume excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Volume $volume)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_volume');
        
        $volume = DB::transaction(function() use($volume, $request)  {
            $tipo = $volume->status ? 0 : 1;
            $volume->update(['status' => $tipo]);
            $volume->criarLogEdicao($request->user());
            return $volume;
        });

        $text = $volume->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Volume {$text} com sucesso!",
            'tipo' => $volume->status ? 'ativo' : 'desativado'
        ]);
    }
}
