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
        Schema::create('PER_cargo_rol', function (Blueprint $table) {
            $table->id('id_cargo_rol');
            $table->foreignId('cargo_id')->constrained('PER_cargos', 'id_cargo')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('rol_id')->constrained('roles', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('creadoPor')->nullable()->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PER_cargo_rol');
    }
};
