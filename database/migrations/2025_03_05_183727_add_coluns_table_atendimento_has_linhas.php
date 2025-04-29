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
        Schema::table('atendimento_has_linhas', function (Blueprint $table) {
            $table->dropColumn('especificacao_aplicacao');
            $table->tinyInteger('aplicacao_personalizada')->default(null)->nullable();
            $table->tinyInteger('estabilidade')->default(null)->nullable();
            $table->tinyInteger('sugestao_formulacao')->default(null)->nullable();
            $table->tinyInteger('suporte_tecnico')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atendimento_has_linhas', function (Blueprint $table) {
            //
        });
    }
};
