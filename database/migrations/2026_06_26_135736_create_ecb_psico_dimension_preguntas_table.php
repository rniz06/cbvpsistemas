<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ECB_psico_dimension_preguntas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pregunta_id')
                ->constrained('ECB_psico_preguntas')
                ->cascadeOnDelete();

            $table->foreignId('dimension_id')
                ->constrained('ECB_psico_dimensiones')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'pregunta_id',
                'dimension_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'ECB_psico_dimension_preguntas'
        );
    }
};