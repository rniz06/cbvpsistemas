<?php

namespace Database\Seeders\ANB\ECB\Psicologia\LSB50;

use Illuminate\Database\Seeder;
use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoPregunta;

class Lsb50PreguntasSeeder extends Seeder
{
    public function run(): void
    {
        $test = PsicoTest::where(
            'codigo',
            'LSB50-ORIGINAL'
        )->firstOrFail();

        $preguntas = [

            1=>"Mi corazón palpita o va muy deprisa.",
            2=>"Me siento triste.",
            3=>"Tengo ganas de romper o destruir algo.",
            4=>"Siento nerviosismo o agitación interior.",
            5=>"Tengo mareos o sensaciones de desmayo.",
            6=>"Me preocupa la dejadez y el descuido.",
            7=>"Tengo que comprobar una y otra vez todo lo que hago.",
            8=>"Me cuesta tomar decisiones.",
            9=>"Me irrito o enfado por cualquier cosa.",
            10=>"Siento miedo en la calle o en espacios abiertos.",
            11=>"Tengo dolores de cabeza.",
            12=>"Me siento decaído o falto de fuerzas.",
            13=>"Me despierto de madrugada.",
            14=>"Duermo inquieto o me despierto mucho por la noche.",
            15=>"Doy vueltas a palabras o ideas que no consigo quitarme de la cabeza.",
            16=>"Me siento incómodo o vergonzoso cuando estoy en reuniones o con gente.",
            17=>"Me vienen ideas de acabar con mi vida.",
            18=>"Tengo miedo sin motivo.",
            19=>"Tengo molestias digestivas o náuseas.",
            20=>"Siento hormigueo o se me duerme alguna parte del cuerpo.",
            21=>"Veo mi futuro sin esperanza.",
            22=>"Me da miedo estar solo.",
            23=>"Tengo ataques de ira que no puedo controlar.",
            24=>"Me siento incomprendido.",
            25=>"Me da miedo salir de casa solo.",
            26=>"Me parece que otras personas me observan o hablan de mí.",
            27=>"Me cuesta dormirme.",
            28=>"Tengo sentimiento de culpa.",
            29=>"Me siento incómodo comiendo o bebiendo en público.",
            30=>"Me siento herido con facilidad.",
            31=>"Me siento incapaz de hacer las cosas o terminar las tareas.",
            32=>"No siento interés por nada.",
            33=>"Tengo manías como repetir cosas innecesariamente (tocar algo, lavarme, comprobar algo, etc.).",
            34=>"Me vienen ideas o imágenes que me dan miedo.",
            35=>"Me siento temeroso.",
            36=>"Tengo que hacer las cosas muy despacio para estar seguro de que las hago bien.",
            37=>"Me siento solo.",
            38=>"Me siento inferior a los demás.",
            39=>"Lloro con facilidad.",
            40=>"Me siento solo aunque tenga compañía.",
            41=>"Me da por gritar o tirar las cosas.",
            42=>"Me siento inútil o poco valioso.",
            43=>"Me duelen los músculos.",
            44=>"Discuto con frecuencia.",
            45=>"Tengo dolores en el corazón o en el pecho.",
            46=>"Me dan ahogos o me cuesta respirar.",
            47=>"Tengo que evitar ciertas cosas, lugares o actividades porque me dan miedo.",
            48=>"Me dan ganas de golpear o hacer daño a alguien.",
            49=>"Siento que todo requiere un gran esfuerzo.",
            50=>"Tengo presentimientos de que va a pasar algo malo."

        ];

        foreach($preguntas as $orden=>$pregunta){

            PsicoPregunta::updateOrCreate(

                [

                    'test_id'=>$test->id,

                    'orden'=>$orden

                ],

                [

                    'pregunta'=>$pregunta

                ]

            );

        }

    }
}