<?php

namespace App\Livewire\Materiales\Mayor;

use App\Exports\ExcelGenericoExport;
use App\Exports\PdfGenericoExport;
use App\Models\Vistas\Materiales\VtMayor;
use App\Models\Vistas\Materiales\VtMayorComentario;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Ficha extends Component
{
    use WithPagination;

    public $movil_id;
    public $buscador = '';
    public $paginado = 5;
    public $mostrarFormAgregarAccion = false;
    public $mostrarFormEditarFicha = false;

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if ($key === 'buscador' || $key === 'paginado') {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.materiales.mayor.ficha', [
            'movil' => VtMayor::findOrFail($this->movil_id),
            'comentarios' => VtMayorComentario::select('id_movil_comentario', 'movil_id', 'accion', 'accion_categoria', 'categoria_detalle', 'comentario', 'nombrecompleto', 'created_at')
                ->where('movil_id', $this->movil_id)
                ->buscador($this->buscador)
                ->orderBy('created_at', 'desc')
                ->paginate($this->paginado)
        ]);
    }

    public function mostrarFormAgregarAccion()
    {
        $this->mostrarFormAgregarAccion = true;
    }

    public function mostrarFormEditarFicha()
    {
        $this->mostrarFormEditarFicha = true;
    }

    public function excelComentarios()
    {
        $datos = VtMayorComentario::select('accion', 'comentario', 'nombrecompleto', 'created_at')
            ->where('movil_id', $this->movil_id)->orderBy('created_at', 'desc')->get();
        $encabezados = ['Acción', 'Comentario', 'Usuarios', 'Fecha y Hora'];

        return Excel::download(new ExcelGenericoExport($datos, $encabezados), 'Mayor Comentarios.xlsx');
    }

    public function pdfComentarios()
    {
        $nombre_archivo = "Mayor Comentarios";
        $datos = VtMayorComentario::select('accion', 'comentario', 'nombrecompleto', 'created_at')
            ->where('movil_id', $this->movil_id)->orderBy('created_at', 'desc')->get();
        $encabezados = ['Acción', 'Comentario', 'Usuarios', 'Fecha y Hora'];

        return (new PdfGenericoExport($datos, $encabezados, $nombre_archivo))->download();
    }
}
