<?php

namespace App\Http\Controllers;

use App\Http\Requests\Atendimentos\CriarAtendimentoAnexoRequest;
use App\Models\Atendimento;
use App\Models\AtendimentoAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AtendimentoAnexos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_atendimento_anexo');
        $search_anexo = $request->input('search_anexo');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $anexos = AtendimentoAnexo::where('atendimento_id', $atendimento->id)->where('descricao', 'like', "%{$search_anexo}%")->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('atendimentos.anexos.table', [
                'anexos' => $anexos,
                'search_anexo' => $search_anexo,
                'atendimento' => $atendimento,
            ]);
        }
        
        return view('atendimentos.anexos.lista', [
            'anexos' => $anexos,
            'search_anexo' => $search_anexo,
            'atendimento' => $atendimento
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_atendimento_anexo');
        
        return view('atendimentos.anexos.form', [
            'atendimento' => $atendimento
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarAtendimentoAnexoRequest $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_atendimento_anexo');
        
        $dados = $request->validated();

        DB::transaction(function() use($dados, $request, $atendimento)  {

            $random = date('YmdHis');
            $arquivo_nome = str_replace(' ', '_',$dados['descricao']);
            $arquivo_venda = $arquivo_nome."_".$random.".".$request->arquivo->extension();

            $path = Storage::disk('public')->putFileAs(
                'atendimentos/'.$atendimento->id.'/arquivos', $request->file('arquivo'), $arquivo_venda
            );

            $data['descricao'] = $dados['descricao'];
            $data['diretorio'] = $path;

            $anexo = $atendimento->anexos()->create($data);
            $anexo->criarLogCadastro($request->user());
        });

        return response()->json([
            'title' => 'Anexo',
            'text' => 'Anexo adicionado com sucesso!',
            'icon' => 'success',
        ]);
        // return redirect()->route('anexoProdutos.index', $atendimento)->with('success', 'Anexo adicionado com sucesso!');
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
    public function edit(Request $request, Atendimento $atendimento, AtendimentoAnexo $anexo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento_anexo');

        return view('atendimentos.anexos.form', [
            'atendimento' => $atendimento,
            'anexo' => $anexo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarAtendimentoAnexoRequest $request, Atendimento $atendimento, AtendimentoAnexo $anexo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento_anexo');
        abort_unless($anexo->atendimento_id === $atendimento->id, 403);
        
        DB::transaction(function() use($anexo, $request, $atendimento)  {
            $data['descricao'] = $request->validated()['descricao'];
            if ($request->hasFile('arquivo')) {
                Storage::disk('public')->delete($anexo->diretorio);

                $random = date('YmdHis');
                $arquivo_nome = str_replace(' ', '_',$request->input('descricao'));
                $arquivo_venda = $arquivo_nome."_".$random.".".$request->arquivo->extension();
    
                $path = Storage::disk('public')->putFileAs(
                    'atendimentos/'.$atendimento->id."/arquivos", $request->file('arquivo'), $arquivo_venda
                );

                $data['diretorio'] = $path;
            }

            $anexo->update($data);
            $anexo->criarLogEdicao($request->user());
        });

        return response()->json([
            'title' => 'Anexo',
            'text' => 'Anexo editado com sucesso!',
            'icon' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Atendimento $atendimento, AtendimentoAnexo $anexo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_atendimento_anexo');
        abort_unless($anexo->atendimento_id === $atendimento->id, 403);

        DB::transaction(function() use($anexo, $request)  {
            if(Storage::disk('public')->exists($anexo->diretorio)){
                Storage::disk('public')->delete($anexo->diretorio);
            }

            $anexo->delete();
            $anexo->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Anexo excluida com sucesso!'
        ]);
    }

    public function getAnexo(Atendimento $atendimento, AtendimentoAnexo $anexo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento_anexo');
        abort_unless($anexo->atendimento_id === $atendimento->id, 403);
        
        return view('atendimentos.anexos.visualizar_anexo', [
            'atendimento' => $atendimento,
            'anexo' => $anexo
        ]);
    }

    public function baixarAnexo(Atendimento $atendimento, AtendimentoAnexo $anexo)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento_anexo');
        abort_unless($anexo->atendimento_id === $atendimento->id, 403);
        
        if(Storage::disk('public')->exists($anexo->diretorio)){
            return Storage::disk('public')->download($anexo->diretorio);
        }
    }
}
