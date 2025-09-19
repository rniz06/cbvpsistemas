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
        Schema::table('MAT_conductores_bomberos', function (Blueprint $table) {
            $table->unsignedBigInteger('resolucion_id')->nullable()->after('resolucion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('MAT_conductores_bomberos', function (Blueprint $table) {
            $table->dropColumn('resolucion_id');
        });
    }
};
