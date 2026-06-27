<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ECB_psico_baremos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('dimension_id')
                ->constrained('ECB_psico_dimensiones')
                ->cascadeOnDelete();

            $table->char('sexo',1)
                ->default('A');

            $table->integer('edad_desde')
                ->nullable();

            $table->integer('edad_hasta')
                ->nullable();

            $table->decimal(
                'desde',
                10,
                2
            );

            $table->decimal(
                'hasta',
                10,
                2
            );

            $table->integer(
                'percentil'
            );

            $table->string(
                'interpretacion'
            )->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'ECB_psico_baremos'
        );
    }
};