<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {

        Schema::create('ECB_aspirantes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('llamado_id')
                ->constrained('ECB_llamados');

            $table->unsignedBigInteger('compania_id');

            $table->string('nombre');

            $table->string('apellido');

            $table->string('cedula')
                ->unique();

            $table->string('celular');

            $table->string('correo')
                ->nullable();

            $table->string('ciudad');

            $table->date('fecha_nacimiento');

            $table->enum('estado',[
                'PRE_ASPIRANTE',
                'ASPIRANTE'
            ])->default('PRE_ASPIRANTE');

            $table->text('observacion')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('ECB_aspirantes');
    }
};