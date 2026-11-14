<?php

namespace App\Livewire\Personal;

use App\Models\Personal;
use App\Models\Personal\Estado;
use App\Models\Usuario;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EnlazarCodigo extends Component
{
    public int $personalId;

    public string $busqueda = '';

    public ?int $personalAnteriorId = null;

    public bool $mostrarConfirmacion = false;

    // Observaciones propias de este enlace.
    public string $observaciones = '';

    public function mount(int $personalId): void
    {
        $this->autorizarAcceso();

        $this->personalId = $personalId;

        $destino = Personal::findOrFail($this->personalId);

        if ((int) $destino->estado_id !== 1) {
            abort(422, 'La ficha nueva debe estar en estado VIGENTE.');
        }
    }

    private function autorizarAcceso(): void
    {
        abort_unless(
            Auth::check()
                && Auth::user()->can('Personal Enlazar Codigo'),
            403,
            'No tenés permiso para enlazar códigos.'
        );
    }

    public function seleccionarAnterior(int $id): void
    {
        $this->autorizarAcceso();

        $destino = Personal::findOrFail($this->personalId);
        $origen = Personal::findOrFail($id);

        if ($origen->idpersonal === $destino->idpersonal) {
            throw ValidationException::withMessages([
                'personalAnteriorId' =>
                    'No podés enlazar una ficha consigo misma.',
            ]);
        }

        if ((int) $origen->estado_id !== 1) {
            throw ValidationException::withMessages([
                'personalAnteriorId' =>
                    'La ficha anterior debe estar VIGENTE para poder enlazarla.',
            ]);
        }

        $yaEnlazada = DB::table('personal_codigos_enlaces')
            ->where(function ($query) use ($id) {
                $query->where('personal_anterior_id', $id)
                    ->orWhere('personal_nueva_id', $id);
            })
            ->exists();

        if ($yaEnlazada) {
            throw ValidationException::withMessages([
                'personalAnteriorId' =>
                    'Esta ficha ya forma parte de un enlace.',
            ]);
        }

        $this->personalAnteriorId = $id;
        $this->mostrarConfirmacion = false;
        $this->observaciones = '';
    }

    public function prepararEnlace(): void
    {
        $this->autorizarAcceso();

        if (!$this->personalAnteriorId) {
            throw ValidationException::withMessages([
                'personalAnteriorId' =>
                    'Primero seleccioná la ficha anterior.',
            ]);
        }

        $this->mostrarConfirmacion = true;
    }

    public function cancelarEnlace(): void
    {
        $this->mostrarConfirmacion = false;
    }

    public function enlazar(): void
    {
        $this->autorizarAcceso();

        if (!$this->personalAnteriorId) {
            throw ValidationException::withMessages([
                'personalAnteriorId' =>
                    'Primero seleccioná la ficha anterior.',
            ]);
        }

        $this->validate([
            'observaciones' => ['nullable', 'string', 'max:5000'],
        ]);

        DB::transaction(function () {
            $destino = Personal::where(
                'idpersonal',
                $this->personalId
            )->lockForUpdate()->firstOrFail();

            $origen = Personal::where(
                'idpersonal',
                $this->personalAnteriorId
            )->lockForUpdate()->firstOrFail();

            if ($origen->idpersonal === $destino->idpersonal) {
                throw ValidationException::withMessages([
                    'personalAnteriorId' =>
                        'No podés enlazar una ficha consigo misma.',
                ]);
            }

            if (
                (int) $destino->estado_id !== 1
                || (int) $origen->estado_id !== 1
            ) {
                throw ValidationException::withMessages([
                    'personalAnteriorId' =>
                        'Ambas fichas deben estar VIGENTES al confirmar el enlace.',
                ]);
            }

            $relacionExistente = DB::table('personal_codigos_enlaces')
                ->where(function ($query) use ($origen, $destino) {
                    $query->where(
                        'personal_anterior_id',
                        $origen->idpersonal
                    )->orWhere(
                        'personal_nueva_id',
                        $origen->idpersonal
                    )->orWhere(
                        'personal_anterior_id',
                        $destino->idpersonal
                    )->orWhere(
                        'personal_nueva_id',
                        $destino->idpersonal
                    );
                })
                ->exists();

            if ($relacionExistente) {
                throw ValidationException::withMessages([
                    'personalAnteriorId' =>
                        'Una de las fichas ya está enlazada.',
                ]);
            }

            $estadoEnlazado = Estado::where(
                'estado',
                'ENLAZADO'
            )->value('idpersonal_estados');

            if (!$estadoEnlazado) {
                throw new \RuntimeException(
                    'No existe el estado ENLAZADO. Ejecutá las migraciones.'
                );
            }

            DB::table('personal_codigos_enlaces')->insert([
                'personal_anterior_id' => $origen->idpersonal,
                'personal_nueva_id' => $destino->idpersonal,
                'usuario_ejecutor_id' => Auth::id(),
                'fecha_enlace' => now(),

                // Se guarda en la fila de este enlace, no en la ficha.
                'observaciones' => trim($this->observaciones) !== ''
                    ? trim($this->observaciones)
                    : null,

                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $origen->update([
                'estado_id' => $estadoEnlazado,
            ]);

            /*
             * Usuario es el modelo que escribe en la tabla real users.
             * SoftDeletes conserva el registro, pero bloquea el acceso
             * a través del modelo User que autentica contra vt_usuarios.
             */
            $usuarioAnterior = Usuario::where(
                'personal_id',
                $origen->idpersonal
            )->first();

            if ($usuarioAnterior) {
                $usuarioAnterior->delete();
            }
        });

        session()->flash(
            'success',
            'Las fichas fueron enlazadas. La ficha anterior quedó ENLAZADA y su acceso fue bloqueado.'
        );

        $this->redirectRoute('personal.show', [
            'personal' => $this->personalId,
        ]);
    }

    public function render()
    {
        $this->autorizarAcceso();

        $destino = Personal::with(['categoria', 'estado'])
            ->findOrFail($this->personalId);

        $fichaAnterior = $this->personalAnteriorId
            ? Personal::with(['categoria', 'estado'])
                ->find($this->personalAnteriorId)
            : null;

        $resultados = collect();

        $termino = trim($this->busqueda);

        if (mb_strlen($termino) >= 2) {
            $resultados = VtPersonales::query()
                ->where('idpersonal', '<>', $this->personalId)
                ->where('estado_id', 1)
                ->where(function ($query) use ($termino) {
                    $query->where('nombrecompleto', 'like', "%{$termino}%")
                        ->orWhere('codigo', 'like', "%{$termino}%")
                        ->orWhere('documento', 'like', "%{$termino}%");
                })
                ->whereNotIn(
                    'idpersonal',
                    DB::table('personal_codigos_enlaces')
                        ->select('personal_anterior_id')
                        ->union(
                            DB::table('personal_codigos_enlaces')
                                ->select('personal_nueva_id')
                        )
                )
                ->orderBy('nombrecompleto')
                ->limit(20)
                ->get();
        }

        return view('livewire.personal.enlazar-codigo', [
            'destino' => $destino,
            'fichaAnterior' => $fichaAnterior,
            'resultados' => $resultados,
        ]);
    }
}