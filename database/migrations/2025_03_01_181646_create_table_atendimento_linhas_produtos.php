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
        Schema::create('atendimento_has_linhas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atendimento_id')->nullable()->default(null)->references('id')->on('atendimentos');
            $table->foreignId('linha_id')->nullable()->default(null)->references('id')->on('linhas');
            $table->foreignId('volume_id')->nullable()->default(null)->references('id')->on('volumes');
            $table->integer('quantidade')->default(0);
            $table->decimal('custo_venda_minimo', 10, 2)->nullable()->default(0);
            $table->decimal('custo_venda_maximo', 10, 2)->nullable()->default(0);
            $table->decimal('aplicacao_minimo', 10, 2)->nullable()->default(0);
            $table->decimal('aplicacao_maximo', 10, 2)->nullable()->default(0);
            $table->integer('numero_sugestoes')->nullable()->default(0);
            $table->tinyInteger('custo_beneficio')->nullable()->default(0);
            $table->tinyInteger('aplicacao')->nullable()->default(0);
            $table->string('base')->nullable()->comment('cliente, propria');
            $table->text('obs')->nullable();
            $table->string('especificacao_aplicacao')->nullable()->comment('aplicacao_personalizada, estabilidade, sugestao_formulacao, suporte_tecnico');
            $table->text('obs_olfativa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimento_has_linhas');
    }
};
