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
        Schema::create('MAT_hidraulicos_herr_modelos', function (Blueprint $table) {
            $table->id('idhidraulico_herr_modelo');
            $table->string('modelo', 45);
            $table->foreignId('marca_id')->references('idhidraulico_herr_marca')->on('MAT_hidraulicos_herr_marcas')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MAT_hidraulicos_herr_modelos');
    }
};
