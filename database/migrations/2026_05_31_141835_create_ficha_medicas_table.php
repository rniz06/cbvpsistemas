<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(
            'ECB_fichas_medicas',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId(
                    'aspirante_id'
                )
                ->constrained(
                    'ECB_aspirantes'
                )
                ->cascadeOnDelete();

                $table->string(
                    'registro_medico'
                )
                ->nullable();

                $table->text(
                    'observacion'
                )
                ->nullable();

                $table->string(
                    'ficha_medica_archivo'
                )
                ->nullable();

                $table->string(
                    'ecg_archivo'
                )
                ->nullable();

                $table->string(
                    'radiografia_torax_archivo'
                )
                ->nullable();

                $table->string(
                    'laboratorio_archivo'
                )
                ->nullable();

                $table->string(
                    'documentacion_complementaria_archivo'
                )
                ->nullable();

                $table->timestamps();

                $table->softDeletes();

            }
        );

    }

    public function down(): void
    {

        Schema::dropIfExists(
            'ECB_fichas_medicas'
        );

    }

};