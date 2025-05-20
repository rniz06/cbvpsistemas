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
        Schema::create('hidraulicos_modelos', function (Blueprint $table) {
            $table->id('id_hidraulico_modelo');
            $table->string('modelo', 45);
            $table->foreignId('marca_id')->references('id_hidraulico_marca')->on('hidraulicos_marcas')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hidraulicos_modelos');
    }
};
