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
        Schema::table('MAT_moviles_comentarios', function (Blueprint $table) {
            $table->unsignedBigInteger('accion_categoria_id')->nullable()->after('accion_id');
            $table->foreign('accion_categoria_id')->references('id_accion_categoria')->on('MAT_acciones_categorias')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('categoria_detalle_id')->nullable()->after('accion_categoria_id');
            $table->foreign('categoria_detalle_id')->references('idaccion_categoria_detalle')->on('MAT_acciones_categorias_detalles')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('MAT_moviles_comentarios', function (Blueprint $table) {
            $table->dropForeign(['accion_categoria_id']);
            $table->dropColumn('accion_categoria_id');
            $table->dropForeign(['categoria_detalle_id']);
            $table->dropColumn('categoria_detalle_id');
        });
    }
};
