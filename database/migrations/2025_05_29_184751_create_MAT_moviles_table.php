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
        Schema::create('MAT_moviles', function (Blueprint $table) {
            $table->id('id_movil');
            $table->string('chasis', 45)->nullable();
            $table->string('detalles', 45)->nullable();
            $table->boolean('operativo')->default(true);
            $table->integer('anho')->nullable();
            $table->string('cubiertas_frente', 15)->nullable();
            $table->string('cubiertas_atras', 15)->nullable();
            $table->string('chapa', 9)->nullable();
            $table->foreignId('movil_tipo_id')->nullable()->references('id_movil_tipo')->on('MAT_moviles_tipos')->onDelete('cascade');
            $table->foreignId('marca_id')->nullable()->references('id_movil_marca')->on('MAT_moviles_marcas')->onDelete('cascade');
            $table->foreignId('modelo_id')->nullable()->references('id_movil_modelo')->on('MAT_moviles_modelos')->onDelete('cascade');
            $table->foreignId('transmision_id')->nullable()->references('id_movil_transmision')->on('MAT_moviles_transmision')->onDelete('cascade');
            $table->foreignId('eje_id')->nullable()->references('id_movil_eje')->on('MAT_moviles_ejes')->onDelete('cascade');
            $table->foreignId('combustible_id')->nullable()->references('id_movil_combustible')->on('MAT_moviles_combustibles')->onDelete('cascade');
            $table->foreignId('operatividad_id')->nullable()->references('id_operatividad')->on('MAT_operatividad')->onDelete('cascade');
            $table->unsignedBigInteger('compania_id')->nullable();
            $table->foreignId('creadoPor')->nullable()->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreignId('actualizadoPor')->nullable()->references('id_usuario')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MAT_moviles');
    }
};
