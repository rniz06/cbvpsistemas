<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignarRolModeradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            269, 330, 393, 1145, 1434, 1716, 1767, 2018, 2188, 2223,
            2453, 2527, 2872, 3054, 3102, 3169, 3530, 3660, 3977, 4153,
            4301, 4491, 4644, 4723, 4993, 5059, 5119, 5425, 5807, 5905,
            5986, 5999, 6085, 6100, 6188, 6208, 6284, 6315, 6343, 6391,
            6431, 6468, 6520, 6570, 6595, 6656, 6696, 6761, 6837, 6963,
            6980, 7376, 7517, 7673, 7798, 7799, 7939, 8000, 8128, 8182,
            8248, 8299, 8471, 8530, 8548, 8549, 8582, 8691, 8737, 8752,
            8792, 8808, 8812, 8824, 8870, 8885, 8911, 8929, 8959, 8983,
            8990, 9152, 9217, 9263, 9298, 9365, 9399, 9430, 9432, 9434,
            9522, 9577, 9631, 9658, 9684, 9774, 9918, 9923, 9939, 9950,
            9953, 9964, 9976, 9998, 10028, 10049, 10089, 10117, 10160
        ];

        foreach ($usuarios as $idUsuario) {
            DB::table('model_has_roles')->updateOrInsert(
                [
                    'role_id' => 2,
                    'model_type' => \App\Models\User::class,
                    'model_id' => $idUsuario
                ]
            );
        }
    }
}
