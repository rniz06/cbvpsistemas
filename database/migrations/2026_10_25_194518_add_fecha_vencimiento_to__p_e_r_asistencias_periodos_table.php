
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('PER_asistencias_periodos', 'fecha_vencimiento')) {
            Schema::table('PER_asistencias_periodos', function (Blueprint $table) {
                $table->date('fecha_vencimiento')
                    ->nullable()
                    ->after('mes_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('PER_asistencias_periodos', 'fecha_vencimiento')) {
            Schema::table('PER_asistencias_periodos', function (Blueprint $table) {
                $table->dropColumn('fecha_vencimiento');
            });
        }
    }
};
