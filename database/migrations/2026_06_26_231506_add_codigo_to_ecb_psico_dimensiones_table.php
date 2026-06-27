<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ECB_psico_dimensiones', function (Blueprint $table) {

            $table->string('codigo',20)
                ->after('orden')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('ECB_psico_dimensiones', function (Blueprint $table) {

            $table->dropColumn('codigo');

        });
    }
};