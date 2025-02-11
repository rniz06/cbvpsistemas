<?php

namespace App\Exports;

use App\Models\Personal;
use App\Models\Personal\Pais;
use App\Models\Vistas\VtPersonales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonalExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VtPersonales::select('nombrecompleto', 'codigo', 'documento', 'fecha_juramento', 'categoria', 'estado', 'pais', 'Sexo', 'compania')->get();
        //return Pais::all();
    }

    /**
     * Retorna las cabeceras del excel
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Nombre Completo", "Codigo", "Documento", "Fecha Juramento", "Categoria", "Estado", "Pais", "Sexo", "Compañia"];
    }
}
