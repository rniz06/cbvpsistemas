<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * La conexión de base de datos que debe utilizar la migración.
     *
     * @var string
     */
    protected $connection = 'sqlite';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ANB_postulantes', function (Blueprint $table) {
            $table->id('id_aspirante');
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('cedula', 15);
            $table->string('celular', 15);
            $table->string('correo', 50);
            $table->string('direccion_particular', 100);
            $table->string('direccion_laboral', 100)->nullable();
            $table->unsignedBigInteger('compania_id');
            $table->year('anho');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ANB_postulantes');
    }
};
