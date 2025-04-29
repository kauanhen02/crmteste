<?php

namespace App\Models;

use App\Support\PesquisaPadraoSupport;
use App\Support\RegistroLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atendimento extends Model
{
    use RegistroLog, SoftDeletes;
    use PesquisaPadraoSupport;

    protected $table = 'atendimentos'; // Nome da tabela

    protected $fillable = [
        'id',
        'cliente_id',
        'tipo_atendimento_id',
        'usuario_abriu_id',
        'status_id',
        'tipo_solicitacao_id',
        'usuario_responsavel_id',
        'assunto',
        'nome_projeto',
        'feito',
        'prazo',
        'meio_contato',
        'contato',
        'nivel_urgencia',
        'obs',
        'solicitado_por',
        'data_recebimento_amostra',
        'exportacao',
        'acao_marketing',
        'piramide_olfativa_1',
        'descricao_olfativa_2',
        'obs_marketing',
        'nossos_concorrentes',
        'clientes_concorrentes',
        'markup',
        'status',

        'data_estimada_ap',
        'data_retorno_ap',
        'elaborador_ap',
        'concluido_ap',
        'obs_ap',
        'turbidez_check_ap',
        'turbidez_desc_ap',
        'coloracao_check_ap',
        'coloracao_desc_ap',
        'nota_fragancia_check_ap',
        'nota_fragancia_desc_ap',
        'precipitacao_check_ap',
        'precipitacao_desc_ap',
        'validacao_check_ap',
        'validacao_desc_ap',
        'desenvolvimento_dev',
        'data_estimada_dev',
        'data_retorno_dev',
        'elaborador_dev',
        'concluido_dev',
        'obs_dev',
        'viscosidade_check_dev',
        'viscosidade_desc_dev',
        'turbidez_check_dev',
        'turbidez_desc_dev',
        'coloracao_check_dev',
        'coloracao_desc_dev',
        'nota_fragancia_check_dev',
        'nota_fragancia_desc_dev',
        'precipitacao_check_dev',
        'precipitacao_desc_dev',
        'validacao_check_dev',
        'validacao_desc_dev',
        'recurso_desenvolvimento',
        'recurso_desenvolvimento_desc',
        'amostra_anexo',
        'amostra_anexo_desc',
        'boletim_tecnico',
        'boletim_tecnico_desc',
        'dados_materia_prima',
        'dados_materia_prima_desc',
        'normas_especificacoes',
        'normas_especificacoes_desc',
        'amostras_item',
        'amostras_item_desc',
        'materias_almoxarifado',
        'materias_almoxarifado_desc',
        'reducao_custo',
        'reducao_custo_desc'
    ];

    protected $casts = [
        'prazo' => 'datetime:d/m/Y',
        'feito' => 'datetime:d/m/Y',
        'data_recebimento_amostra' => 'datetime:d/m/Y',
        'exportacao' => 'boolean'
    ];

    const nenhuma = 'nenhuma';
    const baixa = 'baixa';
    const normal = 'normal';
    const alta = 'alta';
    const urgente = 'urgente';

    const reprovado = 'reprovado';
    const pendente = 'pendente';
    const aprovado = 'aprovado';
    const enviar_laboratorio = 'enviar_laboratorio';
    const avaliacao_final = 'avaliacao_final';
    const concluido = 'concluido';

    static function nivelUrgencia($urgencia = null)
    {
        $data = [
            self::nenhuma => 'Nenhuma',
            self::baixa => 'Baixa',
            self::normal => 'Normal',
            self::alta => 'Alta',
            self::urgente => 'Urgênte'
        ];

        return isset($urgencia) ? $data[$urgencia] : $data;
    }
    
    static function getStatus($status = null)
    {
        $data = [
            self::reprovado => 'Reprovado',
            self::pendente => 'Pendente',
            self::aprovado => 'Aprovado',
            self::enviar_laboratorio => 'Enviado Laboratorio',
            self::avaliacao_final => 'Avaliação Final',
            self::concluido => 'Concluído'
        ];

        return isset($status) ? $data[$status] : $data;
    }

    function usuario() 
    {
        return $this->belongsTo(User::class, 'usuario_abriu_id');
    }

    function cliente() 
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    function clienteTrashed() 
    {
        return $this->belongsTo(Cliente::class, 'cliente_id')->withTrashed();
    }

    function tipoAtendimento() 
    {
        return $this->belongsTo(TipoAtendimento::class, 'tipo_atendimento_id');
    }

    function tipoAtendimentoTrashed() 
    {
        return $this->belongsTo(TipoAtendimento::class, 'tipo_atendimento_id')->withTrashed();
    }

    function user() 
    {
        return $this->belongsTo(User::class, 'usuario_abriu_id');
    }

    function userTrashed() 
    {
        return $this->belongsTo(User::class, 'usuario_abriu_id')->withTrashed();
    }

    function statusLgpd() 
    {
        return $this->belongsTo(StatuLGPD::class, 'status_id');
    }

    function statusLgpdTrashed() 
    {
        return $this->belongsTo(StatuLGPD::class, 'status_id')->withTrashed();
    }

    function tipoSolicitacao() 
    {
        return $this->belongsTo(TipoSolicitacao::class, 'tipo_solicitacao_id');
    }

    function tipoSolicitacaoTrashed() 
    {
        return $this->belongsTo(TipoSolicitacao::class, 'tipo_solicitacao_id')->withTrashed();
    }

    function categoria() 
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    function categoriaTrashed() 
    {
        return $this->belongsTo(Categoria::class, 'categoria_id')->withTrashed();
    }

    function linhas() 
    {
        return $this->hasMany(LinhaProduto::class, 'atendimento_id');
    }

    function envios() 
    {
        return $this->hasMany(AtendimentoEnvio::class, 'atendimento_id');
    }

    function anexos()
    {
        return $this->hasMany(AtendimentoAnexo::class, 'atendimento_id');
    }

    function usuarioResponsavelTrashed()
    {
        return $this->belongsTo(User::class, 'usuario_responsavel_id');
    }
}
