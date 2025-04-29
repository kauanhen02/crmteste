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
        Schema::create('atendimento_has_envios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('atendimento_id')->nullable()->default(null)->references('id')->on('atendimentos');
            $table->foreignId('destino_id')->nullable()->default(null)->references('id')->on('destinos');
            $table->foreignId('envio_id')->nullable()->default(null)->references('id')->on('envios');
            $table->string('contato')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cep')->nullable();
            $table->text('obs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimento_has_envios');
    }
};
