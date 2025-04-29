<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Gate;

class Projetos extends Controller
{
    function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_projeto');
        $search = $request->input('search');
        $status_field = $request->input('status') ? [$request->input('status')] : [];
        if(Gate::check('permissoes_tela', 'permissao_para_visualizar_todos_projeto')){
            $usuario_id = $request->input('usuario_id') ?? null;
        }else{
            $usuario_id = $request->user()->id;
        }

        $status = Atendimento::getStatus();
        unset($status['reprovado']);
        if(!Gate::check('permissoes_tela', 'permissao_para_visualizar_status_aprovar')){
            unset($status['aprovado']);
        }
        if(!Gate::check('permissoes_tela', 'permissao_para_visualizar_status_enviar_laboratorio')){
            unset($status['enviar_laboratorio']);
        }
        if(!Gate::check('permissoes_tela', 'permissao_para_visualizar_status_avaliacao_final')){
            unset($status['avaliacao_final']);
        }
        if(!Gate::check('permissoes_tela', 'permissao_para_visualizar_status_concluir')){
            unset($status['concluido']);
        }

        if(count($status_field) == 0){
            $status_field = array_keys($status);
        }

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $atendimentos = Atendimento::when($status_field, function($q) use($status_field) { $q->whereIn('status', $status_field); })
        ->when($usuario_id, function($q) use($usuario_id) { $q->where('usuario_responsavel_id', $usuario_id); })
        ->where('status', '<>', 'reprovado')
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
                'projeto' => 1,
                'modelos' => $modelos
            ]);
        }

        $usuarios = User::where('status', 1)->get();
        
        return view('projetos.lista', [
            'atendimentos' => $atendimentos,
            'search' => $search,
            'status' => $status,
            'usuarios' => $usuarios,
            'modelos' => $modelos,
            'projeto' => 1
        ]);
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
        $usuarios = User::where('status', 1)->get();

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
            'usuario' => $usuario,
            'usuarios' => $usuarios,
            'projeto' => 1
        ];

        if(isset($request->create)){
            $dados['create'] = $request->boolean('create');
        }

        return view('atendimentos.partials.tabs', $dados);
    }

    function editProjeto(Request $request, Atendimento $atendimento)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_markup');

        DB::transaction(function() use($atendimento, $request)  {
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

    function imprimirProjeto(Request $request, Atendimento $atendimento)
    {
        $modelo = ModeloImpressao::find($request->impressao);
        
        $texto = $this->preencheCampos($modelo->texto, $atendimento, $request);
        
        return view('projetos.impressao', [
            'texto' => $texto
        ]);
    }

    function preencheCampos($texto, $atendimento, $request)
    {

        $linha = '<table class="linha">';
        $linha .= '<tr>';
        $linha .= '<th><b>Linha</b></th>';
        $linha .= '<th><b>Volume</b></th>';
        $linha .= '<th><b>Quantidade</b></th>';
        $linha .= '</tr>';
        
        if($atendimento->linhas->isNotEmpty()){
            
            foreach ($atendimento->linhas as $key => $value) {
                $linha .= '<tr>';
                $linha .= "<td>".$value->linhaTrashed->nome."</td>";
                $linha .= "<td>".$value->volumeTrashed->nome."</td>";
                $linha .= "<td>".$value->quantidade."</td>";
                $linha .= '</tr>';
            }
        }
        
        $linha .= '</table>';

        $acoes_marketing = '';
        if($atendimento->acao_marketing){
            $acoes_marketing .= nl2br($atendimento->obs_marketing);
        }
        if($atendimento->piramide_olfativa_1){
            $acoes_marketing .= '1. Piramide olfativa: documento que identifica a Familia Olfativa a qual uma fragrância pertence, e descreve os principais ingredientes presentes na composição da mesma, considerando os seus três estágios da evolução: notas de saída, corpo e fundo.';
        }
        if($atendimento->descricao_olfativa_2){
            $acoes_marketing .= ' 2. Descrição olfativa: documento que descreve aspectos sensoriais e com conceitos de marketing de uma fragrância considerando os ingredientes presentes na sua construção.';
        }

        $variaveis = [
            '{cliente}' => $atendimento->clienteTrashed->nome ?? '',
            '{usuario_abriu}' => $atendimento->usuario->name ?? '',
            '{tipo_atendimento}' => $atendimento->tipoAtendimentoTrashed->nome ?? '',
            '{assunto}' => $atendimento->assunto ?? '',
            '{nome_projeto}' => $atendimento->nome_projeto ?? '',
            '{status_lgpd}' => $atendimento->statusLgpdTrashed->nome ?? '',
            '{status_projeto}' => $atendimento->status ? Atendimento::getStatus($atendimento->status) : '',
            '{nivel_urgencia}' => $atendimento->nivel_urgencia ? Atendimento::nivelUrgencia($atendimento->nivel_urgencia) : '',
            '{feito_em}' => $atendimento->feito->format('d/m/Y') ?? '',
            '{prazo}' => $atendimento->prazo->format('d/m/Y') ?? '',
            '{meio_contato}' => $atendimento->meio_contato ?? '',
            '{contato}' => $atendimento->contato ?? '',
            '{observacao}' => $atendimento->obs ?? '',
            '{linha_produto}' => $linha,
            '{acoes_marketing}' => $acoes_marketing,
            '{concorrentes_nossos}' => $atendimento->nossos_concorrentes ?? '',
            '{concorrentes_cliente}' => $atendimento->clientes_concorrentes ?? '',
            '{data_hora_atual}' => date('d/m/Y'),
            '{usuario_imprimiu}' => $request->user()->name
        ];
        // dd($variaveis);
        return str_replace(array_keys($variaveis), array_values($variaveis), $texto);
    }
}
