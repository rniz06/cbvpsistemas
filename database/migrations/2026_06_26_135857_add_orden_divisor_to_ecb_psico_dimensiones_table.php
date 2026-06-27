<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ECB_psico_dimensiones', function (Blueprint $table) {

            $table->integer('orden')
                ->default(0)
                ->after('test_id');

            $table->decimal('divisor',8,2)
                ->default(1)
                ->after('nombre');

        });
    }

    public function down(): void
    {
        Schema::table('ECB_psico_dimensiones', function (Blueprint $table) {

            $table->dropColumn([
                'orden',
                'divisor'
            ]);

        });
    }
};