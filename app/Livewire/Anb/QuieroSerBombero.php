<?php

namespace App\Livewire\Anb;

use App\Models\Anb\Postulante;
use App\Models\Public\PublicCompania;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class QuieroSerBombero extends Component
{
    public $companias = []; // PROPIEDAD PARA SELECT

    #[Validate] // PROPIEDADES PARA DEL FORMULARIO
    public $nombres, $apellidos, $cedula, $celular, $correo, $direccion_particular, $direccion_laboral, $compania_id, $acuerdo;

    public function mount()
    {
        $this->companias = PublicCompania::select('id_compania', 'compania')
            ->where('compania', 'like', 'K_%')
            ->orderBY('orden')
            ->get();
    }

    protected function rules()
    {
        return [
            'nombres'              => ['required', 'string', 'max:50'],
            'apellidos'            => ['required', 'string', 'max:50'],
            'cedula'               => ['required', 'max:15', Rule::unique(Postulante::class, 'cedula')],
            'celular'              => ['required', 'max:10', Rule::unique(Postulante::class, 'celular')],
            'correo'               => ['required', 'email', 'max:50', Rule::unique(Postulante::class, 'correo')],
            'direccion_particular' => ['required', 'max:100'],
            'direccion_laboral'    => ['nullable', 'max:100'],
            'compania_id'          => ['required', Rule::exists(PublicCompania::class, 'id_compania')],
            'acuerdo'              => ['accepted'],
        ];
    }

    protected function messages()
    {
        return [
            'compania_id.required' => 'Debe Seleccionar una Opción.',
            'compania_id.exists' => 'La Opción seleccionada no es valida.',
        ];
    }

    public function guardar()
    {
        $this->validate();
        Postulante::create([
            'nombres'              => $this->nombres,
            'apellidos'            => $this->apellidos,
            'cedula'               => $this->cedula,
            'celular'              => $this->celular,
            'correo'               => $this->correo,
            'direccion_particular' => $this->direccion_particular,
            'direccion_laboral'    => $this->direccion_laboral,
            'compania_id'          => $this->compania_id,
            'anho'                 => 2026
        ]);
        session()->flash('success', 'Registro de Pre Inscripción Finalizado Exitosamente!');
        $this->redirectRoute('anb.quiero-ser-bombero');
    }

    public function render()
    {
        return view('livewire.anb.quiero-ser-bombero');
    }
}
