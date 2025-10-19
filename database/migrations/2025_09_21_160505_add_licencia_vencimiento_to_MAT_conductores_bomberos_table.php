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
            $table->date('licencia_vencimiento')->nullable()->after('numero_licencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('MAT_conductores_bomberos', function (Blueprint $table) {
            $table->dropColumn('licencia_vencimiento');
        });
    }
};
