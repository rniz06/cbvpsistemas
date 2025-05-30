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
        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_modulo_id')->nullable()->after('modulo_id');
            $table->foreign('sub_modulo_id')->references('id_sub_modulo')->on('sys_sub_modulos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['sub_modulo_id']);
            $table->dropColumn('sub_modulo_id');
        });
    }
};
