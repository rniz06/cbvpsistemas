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
        Schema::table('GRAL_companias', function (Blueprint $table) {
            $table->boolean('cca_operativo')->default(false)->after('orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('GRAL_companias', function (Blueprint $table) {
            $table->dropColumn('cca_operativo');
        });
    }
};
