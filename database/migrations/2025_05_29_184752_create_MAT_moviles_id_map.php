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
        Schema::create('MAT_moviles_id_map', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_id'); // idmoviles_ficha de materialescbvp
            $table->unsignedBigInteger('new_id'); // nuevo id generado en personalcbvp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MAT_moviles_id_map');
    }
};
