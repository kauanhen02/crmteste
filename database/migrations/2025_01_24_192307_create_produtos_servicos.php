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
        Schema::create('produtos_servicos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('grupo_id')->nullable()->references('id')->on('grupos');
            $table->foreignId('sub_grupo_id')->nullable()->references('id')->on('sub_grupos');
            $table->string('descricao');
            $table->string('descricao_popular')->nullable();
            $table->string('cod')->nullable();
            $table->decimal('custo_medio_ponderado', 15,2)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_servicos');
    }
};
