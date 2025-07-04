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
        Schema::create('user_role_compania', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('compania_id')->nullable();
            $table->timestamps();

            $table->unique(['usuario_id', 'role_id']); // evitar duplicados
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_compania');
    }
};
