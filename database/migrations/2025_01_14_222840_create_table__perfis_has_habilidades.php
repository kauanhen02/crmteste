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
        Schema::create('perfis_has_habilidades', function (Blueprint $table) {
            $table->foreignId('perfil_id')->references('id')->on('perfis');
            $table->foreignId('habilidade_id')->references('id')->on('habilidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfis_has_habilidades');
    }
};
