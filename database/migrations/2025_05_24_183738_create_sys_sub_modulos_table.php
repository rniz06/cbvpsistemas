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
        Schema::create('sys_sub_modulos', function (Blueprint $table) {
            $table->id('id_sub_modulo');
            $table->string('sub_modulo');
            $table->foreignId('modulo_id')->nullable()->constrained('sys_modulos', 'id_sys_modulo')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_sub_modulos');
    }
};
