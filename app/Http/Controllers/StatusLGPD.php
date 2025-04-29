<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest\CriarStatusLGPD;
use App\Models\StatuLGPD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusLGPD extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_status_lgpd');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $status = StatuLGPD::pesquisaPadrao($request, 'search', 'nome')->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('status_lgpd.table', [
                'status' => $status,
                'search' => $search,
            ]);
        }
        
        return view('status_lgpd.lista', [
            'status' => $status,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_status_lgpd');

        return view('status_lgpd.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarStatusLGPD $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_status_lgpd');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $statu = StatuLGPD::create($dados);
            $statu->criarLogCadastro($request->user());
        });

        return redirect()->route('status.index')->with('success', 'Status criado com sucesso!');
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
    public function edit(StatuLGPD $statu)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_status_lgpd');

        return view('status_lgpd.form', [
            'statu' => $statu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarStatusLGPD $request, StatuLGPD $statu)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_status_lgpd');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $statu, $request)  {
            $statu->update($dados);
            $statu->criarLogEdicao($request->user());
        });

        return redirect()->route('status.edit', $statu)->with('success', 'Status editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, StatuLGPD $statu)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_status_lgpd');

        DB::transaction(function() use($statu, $request)  {
            $statu->delete();
            $statu->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Status excluida com sucesso!'
        ]);
        // return redirect()->route('status.index')->with('success', 'StatuLGPD excluido com sucesso!');
    }

    function ativarDesativar(Request $request, StatuLGPD $statu)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_status_lgpd');
        
        $statu = DB::transaction(function() use($statu, $request)  {
            $tipo = $statu->status ? 0 : 1;
            $statu->update(['status' => $tipo]);
            $statu->criarLogEdicao($request->user());
            return $statu;
        });

        $text = $statu->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Status {$text} com sucesso!",
            'tipo' => $statu->status ? 'ativo' : 'desativado'
        ]);
    }
}