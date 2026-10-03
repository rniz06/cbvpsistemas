<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(
            'ECB_psico_opciones',
            function(
                Blueprint $table
            ){

                $table->id();

                $table->foreignId(
                    'pregunta_id'
                )
                ->constrained(
                    'ECB_psico_preguntas'
                )
                ->cascadeOnDelete();

                $table->string(
                    'texto'
                )
                ->nullable();

                $table->string(
                    'imagen'
                )
                ->nullable();

                $table->boolean(
                    'correcta'
                )
                ->default(
                    false
                );

                $table->integer(
                    'valor'
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
            'ECB_psico_opciones'
        );

    }

};