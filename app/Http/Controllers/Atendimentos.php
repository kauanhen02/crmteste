<?php

namespace App\Http\Controllers;

use App\Http\Requests\Atendimentos\AcaoMarketingRequest;
use App\Http\Requests\Atendimentos\CriarAtendimentosRequest;
use App\Models\Atendimento;
use App\Models\AtendimentoAnexo;
use App\Models\AtendimentoEnvio;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\LinhaProduto;
use App\Models\ModeloImpressao;
use App\Models\StatuLGPD;
use App\Models\TipoAtendimento;
use App\Models\TipoSolicitacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Atendimentos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_atendimento');
        $search = $request->input('search');
        $reprovados = $request->boolean('reprovados');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $atendimentos = Atendimento::when($reprovados, function($q) { $q->where('status', 'reprovado'); })
        ->whereHas('clienteTrashed', function($q) use($request){
            $q->where('nome', 'like', "%{$request->search}%");
        })->paginate(10);

        $modelos = ModeloImpressao::select(['id', 'nome'])->where('status', 1)->get();
        $modelos_array = [];
        if(isset($modelos)){
            foreach ($modelos as $key => $value) {
                $modelos_array[$value->id] = $value->nome;
            }
        }
        $modelos = $modelos_array;
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('atendimentos.table', [
                'atendimentos' => $atendimentos,
                'search' => $search,
                'reprovados' => $reprovados,
                'modelos' => $modelos
            ]);
        }
        
        return view('atendimentos.lista', [
            'atendimentos' => $atendimentos,
            'search' => $search,
            'reprovados' => $reprovados,
            'modelos' => $modelos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_atendimento');

        $clientes = Cliente::where('status', 1)->get();
        $tipos_atendimentos = TipoAtendimento::where('status', 1)->get();
        $status_lgpds = StatuLGPD::where('status', 1)->get();
        $usuario = $request->user();

        return view('atendimentos.partials.tabs', [
            'clientes' => $clientes,
            'tipos_atendimentos' => $tipos_atendimentos,
            'status_lgpds' => $status_lgpds,
            'usuario' => $usuario
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarAtendimentosRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_atendimento');

        $dados = $request->validated();
        $atendimento = DB::transaction(function() use($dados, $request)  {
            $atendimento = Atendimento::create($dados);
            $atendimento->criarLogCadastro($request->user());
            return $atendimento;
        });

        return redirect()->route('atendimentos.edit', [$atendimento, 'create' => 1])->with('success', 'Atendimento criado com sucesso!');
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
    public function edit(Request $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento');

        $clientes = Cliente::where('status', 1)->get();
        $tipos_atendimentos = TipoAtendimento::where('status', 1)->get();
        $status_lgpds = StatuLGPD::where('status', 1)->get();
        $usuario = $request->user();
        
        $linhas = LinhaProduto::where('atendimento_id', $atendimento->id)->with('linhaTrashed', 'volumeTrashed')->paginate(10);
        $envios = AtendimentoEnvio::where('atendimento_id', $atendimento->id)->with('destinoTrashed', 'envioTrashed')->paginate(10);
        $anexos = AtendimentoAnexo::where('atendimento_id', $atendimento->id)->paginate(10);
        $search_linha = '';
        $search_destino = '';
        $search_anexo = '';
        $tipo_solicitacoes = TipoSolicitacao::where('status', 1)->get();
        $categorias = Categoria::where('status', 1)->get();

        $dados = [
            'atendimento' => $atendimento,
            'clientes' => $clientes,
            'tipos_atendimentos' => $tipos_atendimentos,
            'status_lgpds' => $status_lgpds,
            'linhas' => $linhas,
            'envios' => $envios,
            'anexos' => $anexos,
            'search_linha' => $search_linha,
            'search_destino' => $search_destino,
            'search_anexo' => $search_anexo,
            'tipo_solicitacoes' => $tipo_solicitacoes,
            'categorias' => $categorias,
            'usuario' => $usuario
        ];

        if(isset($request->create)){
            $dados['create'] = $request->boolean('create');
        }

        return view('atendimentos.partials.tabs', $dados);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarAtendimentosRequest $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_atendimento');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $atendimento, $request)  {
            $atendimento->update($dados);
            $atendimento->criarLogEdicao($request->user());
        });

        return response()->json([
            'title' => 'Atendimento',
            'text' => 'Atendimento editado com sucesso!',
            'icon' => 'success',
        ]);
        // return redirect()->route('atendimentos.edit', $atendimento)->with('success', 'Atendimento editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_atendimento');

        DB::transaction(function() use($atendimento, $request)  {
            $atendimento->delete();
            $atendimento->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Atendimento excluido com sucesso!'
        ]);
        // return redirect()->route('atendimentos.index')->with('success', 'Atendimento excluido com sucesso!');
    }

    function acaoMarketing(AcaoMarketingRequest $request, Atendimento $atendimento)
    {

        DB::transaction(function() use($request, $atendimento){
            $dados = $request->validated();
            $dados['acao_marketing'] = $request->boolean('acao_marketing');
            $dados['piramide_olfativa_1'] = $request->boolean('piramide_olfativa_1');
            $dados['descricao_olfativa_2'] = $request->boolean('descricao_olfativa_2');

            $atendimento->update($dados);
            $atendimento->criarLogEdicao($request->user());
        });

        return response()->json([
            'title' => 'Atendimento',
            'text' => 'Atendimento editado com sucesso!',
            'icon' => 'success',
        ]);
    }

    function concorrente(Request $request, Atendimento $atendimento)
    {

        DB::transaction(function() use($request, $atendimento){
            $dados = $request->input();

            $atendimento->update($dados);
            $atendimento->criarLogEdicao($request->user());
        });

        return response()->json([
            'title' => 'Atendimento',
            'text' => 'Atendimento editado com sucesso!',
            'icon' => 'success',
        ]);
    }

    function changeStatus(Request $request, Atendimento $atendimento)
    {
        $projeto = null;
        if(isset($atendimento->usuario_responsavel_id)){
            $projeto = 1;
        }

        if($request->status == "aprovado"){
            $projeto = 1;
            if(!isset($request->usuario_responsavel_id) || empty($request->usuario_responsavel_id)){
                return response()->json([
                    'title' => 'Error',
                    'text' => 'Informe um usuario responsável!',
                    'icon' => 'error',
                ], 403);
            }
        }
        DB::transaction(function() use($request, $atendimento){
            $dados = [
                'status' => $request->status,
                'usuario_responsavel_id' => $request->usuario_responsavel_id
            ];
            $atendimento->update($dados);
            $atendimento->criarLogEdicao($request->user());
        });

        $usuarios = User::where('status', 1)->get();

        return view('atendimentos/partials/status', ['atendimento' => $atendimento, 'projeto' => $projeto, 'usuarios' => $usuarios]);
    }
}
