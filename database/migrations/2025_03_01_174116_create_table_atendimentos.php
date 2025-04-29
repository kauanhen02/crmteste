<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('cliente_id')->nullable()->default(null)->references('id')->on('clientes');
            $table->foreignId('tipo_atendimento_id')->nullable()->default(null)->references('id')->on('tipo_atendimentos');
            $table->foreignId('usuario_abriu_id')->nullable()->default(null)->references('id')->on('users');
            $table->foreignId('status_id')->nullable()->default(null)->references('id')->on('status_lgpd');
            $table->foreignId('tipo_solicitacao_id')->nullable()->default(null)->references('id')->on('tipo_solicitacoes');
            $table->foreignId('categoria_id')->nullable()->default(null)->references('id')->on('categorias');
            $table->string('assunto')->nullable();
            $table->string('nome_projeto')->nullable();
            $table->date('feito')->nullable();
            $table->date('prazo')->nullable();
            $table->string('meio_contato')->comment('nao_definido, visita, feira, telefone, email, skype, website, whatsapp, outro')->nullable();
            $table->string('contato')->nullable();
            $table->string('nivel_urgencia')->comment('nenhuma, baixa, normal, alta, urgente')->nullable();
            $table->text('obs')->nullable();
            $table->string('solicitado_por')->nullable()->comment('cliente, executivo, nao_selecionado');
            $table->date('data_recebimento_amostra')->nullable();
            $table->tinyInteger('exportacao')->default(0)->nullable();
            $table->tinyInteger('acao_marketing')->default(0)->nullable();
            $table->tinyInteger('piramide_olfativa_1')->default(0)->nullable();
            $table->tinyInteger('descricao_olfativa_2')->default(0)->nullable();
            $table->text('obs_marketing')->nullable()->default(null);
            $table->string('nossos_concorrentes')->nullable()->default(null);
            $table->string('clientes_concorrentes')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};
