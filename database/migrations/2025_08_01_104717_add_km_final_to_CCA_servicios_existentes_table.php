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
        Schema::table('CCA_servicios_existentes', function (Blueprint $table) {
            $table->integer('km_final')->nullable()->after('estado_id');
            $table->boolean('desperfecto')->nullable()->after('km_final');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('CCA_servicios_existentes', function (Blueprint $table) {
            $table->dropColumn('km_final');
            $table->dropColumn('desperfecto');
        });
    }
};
