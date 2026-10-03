<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class ECBPreAspirantesSeeder_Parte2 extends Seeder{
public function run(): void{
DB::table('ECB_aspirantes')->insert([
    [
        'llamado_id'=>1,
        'compania_id'=>63,
        'nombre'=>'VICENTE ADRIAN',
        'apellido'=>'Benitez Morales',
        'cedula'=>'3715924',
        'celular'=>null,
        'correo'=>null,
        'ciudad'=>null,
        'fecha_nacimiento'=>'1992-08-05',
        'sexo'=>'M',
        'estado'=>'PRE_ASPIRANTE',
        'observacion'=>null,
        'created_at'=>now(),
        'updated_at'=>now(),
    ],
    [
        'llamado_id'=>1,
        'compania_id'=>11,
        'nombre'=>'Ana Yeruti',
        'apellido'=>'Vera Ramirez',
        'cedula'=>'4784350',
        'celular'=>null,
        'correo'=>null,
        'ciudad'=>null,
        'fecha_nacimiento'=>'1997-01-17',
        'sexo'=>'F',
        'estado'=>'PRE_ASPIRANTE',
        'observacion'=>null,
        'created_at'=>now(),
        'updated_at'=>now(),
    ],
    [
        'llamado_id'=>1,
        'compania_id'=>48,
        'nombre'=>'Sofia Araceli',
        'apellido'=>'Aquino Ortega',
        'cedula'=>'5454893',
        'celular'=>null,
        'correo'=>null,
        'ciudad'=>null,
        'fecha_nacimiento'=>'1998-05-15',
        'sexo'=>'F',
        'estado'=>'PRE_ASPIRANTE',
        'observacion'=>null,
        'created_at'=>now(),
        'updated_at'=>now(),
    ],
    [
        'llamado_id'=>1,
        'compania_id'=>71,
        'nombre'=>'RAMON IGNACIO',
        'apellido'=>'Insfran Cuevas',
        'cedula'=>'5899701',
        'celular'=>null,
        'correo'=>null,
        'ciudad'=>null,
        'fecha_nacimiento'=>'1990-08-08',
        'sexo'=>'M',
        'estado'=>'PRE_ASPIRANTE',
        'observacion'=>null,
        'created_at'=>now(),
        'updated_at'=>now(),
    ],
    [
        'llamado_id'=>1,
        'compania_id'=>50,
        'nombre'=>'Mathias Ivan',
        'apellido'=>'Miranda Lopez',
        'cedula'=>'6337092',
        'celular'=>null,
        'correo'=>null,
        'ciudad'=>null,
        'fecha_nacimiento'=>'2004-09-23',
        'sexo'=>'M',
        'estado'=>'PRE_ASPIRANTE',
        'observacion'=>null,
        'created_at'=>now(),
        'updated_at'=>now(),
    ],

  
    [
        'llamado_id'=>1,
        'compania_id'=>11,
        'nombre'=>'Andrea Isabel',
        'apellido'=>'Rossi Constantini',
        'cedula'=>'7126037',
        'celular'=>null,
        'correo'=>null,
        'ciudad'=>null,
        'fecha_nacimiento'=>'2001-09-22',
        'sexo'=>'F',
        'estado'=>'PRE_ASPIRANTE',
        'observacion'=>null,
        'created_at'=>now(),
        'updated_at'=>now(),
    ],


   
]);




}
}