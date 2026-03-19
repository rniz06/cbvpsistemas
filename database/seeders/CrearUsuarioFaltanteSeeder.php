<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CrearUsuarioFaltanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
                        INSERT INTO users (personal_id, password, created_at, updated_at)
                        SELECT p.idpersonal, ?, NOW(), NOW()
                        FROM personal p
                        LEFT JOIN users u ON p.idpersonal = u.personal_id
                        WHERE u.personal_id IS NULL
                    ", ['default123']);
    }
}
