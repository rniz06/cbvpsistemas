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
        Schema::create('mesa_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesa_id')->constrained('mesas', 'id_mesa')->onDelete('cascade');
            $table->integer('personal_id')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal        
            $table->integer('votos')->default(0);
            $table->timestamps();

            $table->foreign('personal_id')->references('idpersonal')->on('personal')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesa_personal');
    }
};
