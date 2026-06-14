<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(

            'ECB_psico_sesiones',

            function(
                Blueprint $table
            ){

                $table->id();

                $table->foreignId(
                    'aspirante_id'
                )
                ->constrained(
                    'ECB_aspirantes'
                )
                ->cascadeOnDelete();

                $table->foreignId(
                    'test_id'
                )
                ->constrained(
                    'ECB_psico_tests'
                )
                ->cascadeOnDelete();

                $table->dateTime(
                    'inicio'
                );

                $table->dateTime(
                    'expira_en'
                );

                $table->boolean(
                    'finalizado'
                )
                ->default(
                    false
                );

                $table->integer(
                    'puntaje'
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
            'ECB_psico_sesiones'
        );

    }

};