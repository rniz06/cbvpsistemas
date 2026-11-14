<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('permissions')->updateOrInsert(
            [
                'name' => 'Personal rectificaciones',
                'guard_name' => 'web',
            ],
            [
                'modulo_id' => 1,
                'sub_modulo_id' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('permissions')
            ->where('name', 'Personal rectificaciones')
            ->where('guard_name', 'web')
            ->delete();
    }
};