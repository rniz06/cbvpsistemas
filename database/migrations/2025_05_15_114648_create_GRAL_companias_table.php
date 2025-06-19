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
        Schema::create('GRAL_companias', function (Blueprint $table) {
            $table->id('id_compania');
            $table->string('compania', 45);
            $table->foreignId('ciudad_id')->constrained('GRAL_ciudades', 'id_ciudad')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('region_id')->constrained('GRAL_regiones', 'id_region')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('orden')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('GRAL_companias');
    }
};
