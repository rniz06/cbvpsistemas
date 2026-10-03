<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ECB_psico_resultados', function (Blueprint $table) {

            $table->id();

            $table->foreignId('sesion_id')
                ->constrained('ECB_psico_sesiones')
                ->cascadeOnDelete();

            $table->foreignId('dimension_id')
                ->constrained('ECB_psico_dimensiones')
                ->cascadeOnDelete();

            $table->decimal(
                'puntaje',
                10,
                2
            )->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'ECB_psico_resultados'
        );
    }
};