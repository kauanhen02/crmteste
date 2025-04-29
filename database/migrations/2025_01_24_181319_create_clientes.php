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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('carteira_id')->nullable()->default(null)->references('id')->on('carteiras');
            $table->foreignId('segmento_id')->nullable()->default(null)->references('id')->on('segmentos');
            $table->foreignId('forma_atuacao_id')->nullable()->default(null)->references('id')->on('formas_atuacoes');
            $table->foreignId('status_lgpd_id')->nullable()->default(null)->references('id')->on('status_lgpd');
            $table->string('nome');
            $table->string('razao_social')->nullable();
            $table->string('cnpj', 30);
            $table->string('telefone', 30);
            $table->string('email')->nullable();
            $table->string('cep', 11)->nullable();
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('complemento')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
