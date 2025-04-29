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
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->string('data_estimada_ap')->default(null)->nullable();
            $table->string('data_retorno_ap')->default(null)->nullable();
            $table->string('elaborador_ap')->default(null)->nullable();
            $table->string('concluido_ap')->default(null)->nullable();
            $table->string('obs_ap')->default(null)->nullable();
            $table->tinyInteger('turbidez_check_ap')->default(null)->nullable();
            $table->string('turbidez_desc_ap')->default(null)->nullable();
            $table->tinyInteger('coloracao_check_ap')->default(null)->nullable();
            $table->string('coloracao_desc_ap')->default(null)->nullable();
            $table->tinyInteger('nota_fragancia_check_ap')->default(null)->nullable();
            $table->string('nota_fragancia_desc_ap')->default(null)->nullable();
            $table->tinyInteger('precipitacao_check_ap')->default(null)->nullable();
            $table->string('precipitacao_desc_ap')->default(null)->nullable();
            $table->tinyInteger('validacao_check_ap')->default(null)->nullable();
            $table->string('validacao_desc_ap')->default(null)->nullable();

            $table->string('desenvolvimento_dev')->default(null)->nullable();
            $table->string('data_estimada_dev')->default(null)->nullable();
            $table->string('data_retorno_dev')->default(null)->nullable();
            $table->string('elaborador_dev')->default(null)->nullable();
            $table->string('concluido_dev')->default(null)->nullable();
            $table->string('obs_dev')->default(null)->nullable();
            $table->tinyInteger('viscosidade_check_dev')->default(null)->nullable();
            $table->string('viscosidade_desc_dev')->default(null)->nullable();
            $table->tinyInteger('turbidez_check_dev')->default(null)->nullable();
            $table->string('turbidez_desc_dev')->default(null)->nullable();
            $table->tinyInteger('coloracao_check_dev')->default(null)->nullable();
            $table->string('coloracao_desc_dev')->default(null)->nullable();
            $table->tinyInteger('nota_fragancia_check_dev')->default(null)->nullable();
            $table->string('nota_fragancia_desc_dev')->default(null)->nullable();
            $table->tinyInteger('precipitacao_check_dev')->default(null)->nullable();
            $table->string('precipitacao_desc_dev')->default(null)->nullable();
            $table->tinyInteger('validacao_check_dev')->default(null)->nullable();
            $table->string('validacao_desc_dev')->default(null)->nullable();

            $table->tinyInteger('recurso_desenvolvimento')->default(null)->nullable();
            $table->string('recurso_desenvolvimento_desc')->default(null)->nullable();
            $table->tinyInteger('amostra_anexo')->default(null)->nullable();
            $table->string('amostra_anexo_desc')->default(null)->nullable();
            $table->tinyInteger('boletim_tecnico')->default(null)->nullable();
            $table->string('boletim_tecnico_desc')->default(null)->nullable();
            $table->tinyInteger('dados_materia_prima')->default(null)->nullable();
            $table->string('dados_materia_prima_desc')->default(null)->nullable();
            $table->tinyInteger('normas_especificacoes')->default(null)->nullable();
            $table->string('normas_especificacoes_desc')->default(null)->nullable();
            $table->tinyInteger('amostras_item')->default(null)->nullable();
            $table->string('amostras_item_desc')->default(null)->nullable();
            $table->tinyInteger('materias_almoxarifado')->default(null)->nullable();
            $table->string('materias_almoxarifado_desc')->default(null)->nullable();
            $table->tinyInteger('reducao_custo')->default(null)->nullable();
            $table->string('reducao_custo_desc')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            //
        });
    }
};
