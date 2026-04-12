<?php

namespace Database\Seeders;

use App\Models\Materiales\Menor\Categoria;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialMenorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # CREAR CATEGORIAS
        $categorias = ['MATERIAL MENOR', 'EQUIPOS FORESTALES', 'ERAS'];
        foreach ($categorias as $categoria) {
            Categoria::create([
                'nombre'    => $categoria,
                'creadoPor' => 10231, # USUARIO: MARCOS MEZA
            ]);
        }

        # CREAR COMPONENTES
        DB::table('MAT_menor_componentes')->insert([
            
            // =========================
            // CATEGORIA 1
            // =========================
            ["nombre" => "PITON DE 50MM", "categoria_id" => 1],
            ["nombre" => "PITON DE 70 MM", "categoria_id" => 1],
            ["nombre" => "MANGA DE 50MM", "categoria_id" => 1],
            ["nombre" => "MANGA DE 70MM", "categoria_id" => 1],
            ["nombre" => "REDUCTOR 70 - 50", "categoria_id" => 1],
            ["nombre" => "REDUCTOR 70 - 65", "categoria_id" => 1],
            ["nombre" => "REDUCTOR 100 - 70", "categoria_id" => 1],
            ["nombre" => "ADAPTADOR DE 50MM", "categoria_id" => 1],
            ["nombre" => "ADAPTADOR DE 70MM", "categoria_id" => 1],
            ["nombre" => "BIFURCA", "categoria_id" => 1],
            ["nombre" => "TRIFURCA", "categoria_id" => 1],
            ["nombre" => "CODO DE 70", "categoria_id" => 1],
            ["nombre" => "CODO DE 50", "categoria_id" => 1],
            ["nombre" => "LLAVE DE MANGAS", "categoria_id" => 1],
            ["nombre" => "LLAVE DE CIERRE RÁPIDO", "categoria_id" => 1],
            ["nombre" => "LLAVE DE HIDRANTE TIGRE", "categoria_id" => 1],
            ["nombre" => "LLAVE DE HIDRANTE DARLING", "categoria_id" => 1],
            ["nombre" => "FILTRO P/ MANGUEROTE", "categoria_id" => 1],
            ["nombre" => "MANGUEROTE DE SUCCIÓN", "categoria_id" => 1],
            ["nombre" => "ABRAZADERA P/MANGA 70MM", "categoria_id" => 1],
            ["nombre" => "ABRAZADERA P/MANGA 50MM", "categoria_id" => 1],
            ["nombre" => "PANTALLA CORTAFUEGO", "categoria_id" => 1],
            ["nombre" => "EXTINTOR CO2", "categoria_id" => 1],
            ["nombre" => "EXTINTOR PQS", "categoria_id" => 1],

            ["nombre" => "DOSIFICADOR", "categoria_id" => 1],
            ["nombre" => "MANGUERÍN RÍGIDO", "categoria_id" => 1],
            ["nombre" => "LANZA P/ ESPUMA", "categoria_id" => 1],
            ["nombre" => "MANGUERÍN DE GOMA", "categoria_id" => 1],
            ["nombre" => "PALA", "categoria_id" => 1],
            ["nombre" => "PICO", "categoria_id" => 1],
            ["nombre" => "AZADA", "categoria_id" => 1],
            ["nombre" => "BICHERO", "categoria_id" => 1],
            ["nombre" => "RASTRILLO", "categoria_id" => 1],
            ["nombre" => "MAZO", "categoria_id" => 1],
            ["nombre" => "CINCEL", "categoria_id" => 1],
            ["nombre" => "HACHA", "categoria_id" => 1],
            ["nombre" => "BARRETA", "categoria_id" => 1],
            ["nombre" => "CORTAHIERRO", "categoria_id" => 1],
            ["nombre" => "CORTAPERNOS", "categoria_id" => 1],
            ["nombre" => "PATA DE CABRA", "categoria_id" => 1],
            ["nombre" => "MOCHILA", "categoria_id" => 1],
            ["nombre" => "LONA", "categoria_id" => 1],
            ["nombre" => "POLEA", "categoria_id" => 1],
            ["nombre" => "MANTA", "categoria_id" => 1],
            ["nombre" => "TRÍPODE", "categoria_id" => 1],
            ["nombre" => "PIEZA 8", "categoria_id" => 1],
            ["nombre" => "ROLDANA", "categoria_id" => 1],
            ["nombre" => "MOSQUETÓN", "categoria_id" => 1],
            ["nombre" => "ASCENDEDOR", "categoria_id" => 1],
            ["nombre" => "ARNES SUIZO", "categoria_id" => 1],
            ["nombre" => "SOGA TUBULAR", "categoria_id" => 1],
            ["nombre" => "CABO DE VIDA", "categoria_id" => 1],
            ["nombre" => "ARNES PECTORAL", "categoria_id" => 1],
            ["nombre" => "CUERDA UTILITARIA", "categoria_id" => 1],
            ["nombre" => "CAÑO PARA NUDOS", "categoria_id" => 1],
            ["nombre" => "PROTECTOR DE SOGA", "categoria_id" => 1],
            ["nombre" => "CASCO DE RESCATE", "categoria_id" => 1],
            ["nombre" => "CHALECO SALVAVIDAS", "categoria_id" => 1],
            ["nombre" => "ASERRÍN", "categoria_id" => 1],
            ["nombre" => "GUANTES", "categoria_id" => 1],
            ["nombre" => "SOMBRERO", "categoria_id" => 1],
            ["nombre" => "AHUMADOR", "categoria_id" => 1],
            ["nombre" => "MAMELUCO", "categoria_id" => 1],
            ["nombre" => "TRÍPODE", "categoria_id" => 1],
            ["nombre" => "CARRETEL", "categoria_id" => 1],
            ["nombre" => "LINTERNA", "categoria_id" => 1],
            ["nombre" => "REFLECTOR", "categoria_id" => 1],
            ["nombre" => "MOTOGENERADOR", "categoria_id" => 1],
            ["nombre" => "TOMACORRIENTES", "categoria_id" => 1],
            ["nombre" => "MACHETE", "categoria_id" => 1],
            ["nombre" => "ESCOBILLÓN", "categoria_id" => 1],
            ["nombre" => "MOTOSIERRA", "categoria_id" => 1],
            ["nombre" => "MOTOBOMBA", "categoria_id" => 1],
            ["nombre" => "DESTRONZADOR", "categoria_id" => 1],
            ["nombre" => "ESCALA DOBLE", "categoria_id" => 1],
            ["nombre" => "ESCALA SIMPLE", "categoria_id" => 1],
            ["nombre" => "CABO DE ACERO", "categoria_id" => 1],
            ["nombre" => "SIERRA POLICORTE", "categoria_id" => 1],
            ["nombre" => "CINTA DELIMITADORA", "categoria_id" => 1],
            ["nombre" => "BASTÓN P/ ANIMALES", "categoria_id" => 1],
            ["nombre" => "CONOS DE ADVERTENCIA", "categoria_id" => 1],
            ["nombre" => "CAJA DE HERRAMIENTAS", "categoria_id" => 1],
            ["nombre" => "CHALECO DE SEGURIDAD", "categoria_id" => 1],

            // =========================
            // CATEGORIA 2
            // =========================
            ["nombre" => "CASCOS FORESTALES AMARILLOS", "categoria_id" => 2],
            ["nombre" => "CASCOS FORESTALES ROJOS", "categoria_id" => 2],
            ["nombre" => "PANTALÓN IGNÍFUGO COLOR VERDE", "categoria_id" => 2],
            ["nombre" => "CAMISA IGNÍFUGA COLOR AMARILLO", "categoria_id" => 2],
            ["nombre" => "CUBRENUCAS VFT", "categoria_id" => 2],
            ["nombre" => "BOTAS FORESTALES", "categoria_id" => 2],
            ["nombre" => "GUANTES FORESTALES", "categoria_id" => 2],
            ["nombre" => "ANTIPARRAS", "categoria_id" => 2],
            ["nombre" => "LINTERNA LED", "categoria_id" => 2],
            ["nombre" => "MÁSCARAS ANTIHUMO CON FILTRO DE CARBONO", "categoria_id" => 2],
            ["nombre" => "LINTERNA FRONTAL PARA CASCO", "categoria_id" => 2],
            ["nombre" => "PULASKY CON MANGO Y FUNDA", "categoria_id" => 2],
            ["nombre" => "MCLEOD CON MANGO Y FUNDA", "categoria_id" => 2],
            ["nombre" => "ASADÓN CON MANGO", "categoria_id" => 2],
            ["nombre" => "RASTRILLO FORESTAL CON MANGO Y FUNDA", "categoria_id" => 2],
            ["nombre" => "GORGI CON FUNDA", "categoria_id" => 2],
            ["nombre" => "BATE FUEGO", "categoria_id" => 2],
            ["nombre" => "MOCHILA FORESTAL", "categoria_id" => 2],
            ["nombre" => "PALA FORESTAL", "categoria_id" => 2],
            ["nombre" => "ESCOBA METÁLICA REFORZADA", "categoria_id" => 2],
            ["nombre" => "MOTOSIERRA STIHL", "categoria_id" => 2],
            ["nombre" => "QUEMADOR DE GOTEO", "categoria_id" => 2],
            ["nombre" => "MOCHILA PARA TRANSPORTE DE MANGAS", "categoria_id" => 2],
            ["nombre" => "ANEMÓMETRO PORTÁTIL", "categoria_id" => 2],
            ["nombre" => "REFUGIO INIFUGO", "categoria_id" => 2],
            ["nombre" => "PROTECTOR AUDITIVO DE TRIPLE BARRERA", "categoria_id" => 2],

            // =========================
            // CATEGORIA 3
            // =========================
            ["nombre" => "CILINDRO", "categoria_id" => 3],
            ["nombre" => "MASCARA", "categoria_id" => 3],
            ["nombre" => "CARGADOR DE AUTONOMO", "categoria_id" => 3],
            ["nombre" => "HUD", "categoria_id" => 3],
            ["nombre" => "AMP. DE VOZ", "categoria_id" => 3],
            ["nombre" => "BOLSO RIT", "categoria_id" => 3],
        ]);

        $permisos = [
            'Material Menor Marcas Listar',
            'Material Menor Marcas Crear',
            'Material Menor Marcas Editar',
            'Material Menor Marcas Eliminar',

            'Material Menor Agregar Accion',
            'Material Menor Ver Compania',
            'Material Menor Ver Ficha',
        ];

        foreach ($permisos as $permiso) {
            Permission::create([
                'name' => $permiso,
                'guard_name' => 'web',
                'modulo_id' => 5, # Materiales
                'sub_modulo_id' => 7, # Menor
            ]);
        }
    }
}
