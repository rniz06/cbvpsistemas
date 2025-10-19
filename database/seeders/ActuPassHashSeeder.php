<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ActuPassHashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vt_usuarios')
        ->select('id_usuario', 'codigo')
        ->whereRaw('LENGTH(password) != 60')
        ->orderBy('id_usuario')
        ->chunk(500, function ($usuarios) {
            foreach ($usuarios as $x) {
                DB::table('users')
                    ->where('id_usuario', $x->id_usuario)
                    ->update([
                        'password' => Hash::make($x->codigo),
                    ]);
            }
        });
    }
}
