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
        Schema::create('moviles_modelos', function (Blueprint $table) {
            $table->id('id_movil_modelo');
            $table->string('modelo', 45);
            $table->foreignId('marca_id')->references('id_movil_marca')->on('moviles_marcas')->onDelete('cascade');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moviles_modelos');
    }
};
