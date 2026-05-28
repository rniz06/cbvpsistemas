<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Componente;
use App\Enums\Materiales\Menor\TipoMenor;
use Illuminate\Support\Facades\DB;

class MaterialMenorItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            $creadoPor = 10231;

            $data = [
                'EQUIPOS DE COMUNICACION' => [
                    'RADIO BASE',
                    'RADIO PORTATIL',
                    'RADIO BASE EN MOVIL',
                    'ANTENA',
                    'TORRE',
                    'FUENTE ESTABILIZADA',
                    'UPS/BATERIA',
                ],

                'EQUIPOS DE EXTINCION' => [
                    'PITON DE 25MM',
                    'PITON DE 50MM',
                    'PITON DE 70 MM',
                    'MANGUERA 25MM',
                    'MANGUERA DE 50MM',
                    'MANGUERA DE 70MM',
                    'MANGUERA DE 100MM',
                    'MANGUERA LDH',
                    'REDUCTOR 50-25',
                    'REDUCTOR 70 - 50',
                    'REDUCTOR 70 - 65',
                    'REDUCTOR 100 - 70',
                    'ADAPTADOR DE 25MM',
                    'ADAPTADOR DE 50MM',
                    'ADAPTADOR DE 70MM',
                    'ADAPTADOR DE 100MM',
                    'BIFURCA',
                    'TRIFURCA',
                    'CODO DE 70',
                    'CODO DE 50',
                    'LLAVE DE MANGUERAS',
                    'LLAVE DE CIERRE RÁPIDO',
                    'LLAVE DE HIDRANTE TIGRE',
                    'LLAVE DE HIDRANTE DARLING',
                    'FILTRO P/ MANGUEROTE',
                    'MANGUEROTE DE SUCCIÓN',
                    'ABRAZADERA P/MANGA 70MM',
                    'ABRAZADERA P/MANGA 50MM',
                    'PANTALLA CORTAFUEGO',
                    'EXTINTOR CO2',
                    'EXTINTOR PQS',
                    'EXTINTOR OTRO ESPECIFICAR',
                    'DOSIFICADOR',
                    'MANGUERÍN RÍGIDO',
                    'LANZA P/ ESPUMA',
                    'MANGUERÍN DE GOMA',
                    'BIDÓN DE .....LTS.',
                    'PALA',
                    'PICO',
                    'AZADA',
                    'BICHERO',
                    'RASTRILLO',
                    'MAZO',
                    'CINCEL',
                    'HACHA',
                    'BARRETA',
                    'CORTAHIERRO',
                    'CORTAPERNOS',
                    'PATA DE CABRA',
                    'PILETA',
                ],

                'EQUIPOS FORESTALES' => [
                    'CASCOS FORESTALES AMARILLOS',
                    'CASCOS FORESTALES ROJOS',
                    'PANTALÓN IGNÍFUGO COLOR VERDE',
                    'CAMISA IGNÍFUGA COLOR AMARILLO',
                    'CUBRENUCAS VFT',
                    'BOTAS FORESTALES',
                    'GUANTES FORESTALES',
                    'ANTIPARRAS',
                    'LINTERNA LED',
                    'MÁSCARAS ANTIHUMO CON FILTRO DE CARBONO',
                    'LINTERNA FRONTAL PARA CASCO',
                    'PULASKY CON MANGO Y FUNDA',
                    'MCLEOD CON MANGO Y FUNDA',
                    'ASADÓN CON MANGO',
                    'RASTRILLO FORESTAL CON MANGO Y FUNDA',
                    'GORGI CON FUNDA',
                    'BATE FUEGO',
                    'MOCHILA FORESTAL',
                    'PALA FORESTAL',
                    'ESCOBA METÁLICA REFORZADA',
                    'MOTOSIERRA STIHL',
                    'QUEMADOR POR GOTEO',
                    'MOCHILA PARA TRANSPORTE DE MANGAS',
                    'ANEMÓMETRO PORTÁTIL',
                    'REFUGIO INGIFUGO',
                    'PROTECTOR AUDITIVO DE TRIPLE BARRERA',
                ],

                'EQUIPOS PARA RESCATE VERTICAL Y FIJACION' => [
                    'MOCHILA',
                    'LONA',
                    'POLEA',
                    'MANTA',
                    'TRÍPODE',
                    'PIEZA 8',
                    'ROLDANA',
                    'MOSQUETÓN',
                    'ASCENDEDOR',
                    'ARNÉS SUIZO',
                    'SOGA TUBULAR',
                    'CABO DE VIDA',
                    'ARNÉS PECTORAL',
                    'CUERDA UTILITARIA',
                    'VARA PARA NUDOS',
                    'PROTECTOR DE SOGA',
                    'CASCO DE RESCATE',
                    'CHALECO SALVAVIDAS',
                    'TRÍPODE',
                    'LINTERNA',
                    'REFLECTOR',
                    'PROLONGADOR/TOMACORRIENTES',
                ],

                'EQUIPOS Y HERRAMIENTAS MANUALES' => [
                    'MACHETE',
                    'ESCOBILLÓN',
                    'ARCO TRONZADOR',
                    'ESCALERA DE 3 O MAS TRAMOS',
                    'ESCALERA DOBLE',
                    'ESCALERA SIMPLE',
                    'ESCALERA BALCONERA',
                    'CINTA DELIMITADORA',
                    'BASTÓN P/ ANIMALES',
                    'CONOS DE ADVERTENCIA',
                    'CAJA DE HERRAMIENTAS',
                    'CHALECOS DE SEGURIDAD',
                    'BARRA DE TIRO',
                    'CABO DE ACERO',
                    'GRILLETES',
                    'ASERRÍN',
                    'GUANTES',
                    'SOMBRERO',
                    'AHUMADOR',
                    'MAMELUCO',
                ],

                'EQUIPOS Y HERRAMIENTAS MOTORIZADAS' => [
                    'MOTOBOMBA',
                    'GENERADOR',
                    'MOTOSIERRA',
                    'MOTOPULVERIZADORA',
                    'AMOLADORA',
                    'SIERRA POLICORTE',
                    'ROTOMARTILLO',
                    'DESMALEZADORA',
                    'TALADRO',
                    'SIERRA RECIPROCA',
                    'COMPRESOR DE AIRE',
                    'COMPRESOR DE AIRE RESPIRABLE',
                ],
            ];

            foreach ($data as $categoriaNombre => $items) {

                $categoriaId = Categoria::where('nombre', $categoriaNombre)
                    ->value('id_menor_categoria');

                if (!$categoriaId) {
                    throw new \Exception("No se encontró la categoría: $categoriaNombre");
                }

                $insertData = array_map(fn ($nombre) => [
                    'nombre' => $nombre,
                    'tipo_id' => TipoMenor::MENOR,
                    'categoria_id' => $categoriaId,
                    'creadoPor' => $creadoPor,
                ], $items);

                Componente::insert($insertData);
            }
        });
    }
}
