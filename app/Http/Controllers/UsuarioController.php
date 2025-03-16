<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Models\Personal;
use App\Models\Role;
use App\Models\User;
use App\Models\Usuario;
use App\Models\Vistas\VtUsuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Usuarios Listar|Usuarios Crear|Usuarios Editar|Usuarios Eliminar', ['only' => ['index', 'show']]);
        $this->middleware('permission:Usuarios Crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:Usuarios Editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Usuarios Eliminar', ['only' => ['destroy']]);
        $this->middleware('permission:Usuarios Asignar Roles', ['only' => ['asignarrolevista', 'asignarrole']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.index', compact('roles'));
    }

    /**
     * Metodo que muestra el formulario para asignar rol a un usuario.
     */
    public function asignarrolevista($user)
    {
        $usuario = VtUsuario::where('id_usuario', $user)->first();
        $roles = Role::pluck('name', 'name')->all();
        $user = User::find($user);
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('usuarios.asignar-roles', compact('roles', 'usuario', 'userRole'));
    }

    /**
     * Metodo para asignar rol a un usuario.
     */
    public function asignarrole(Request $request, User $user)
    {
        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index')
            ->with('success', 'Rol asignado correctamente');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsuarioRequest $request)
    {
        $personal = Personal::find($request->personal_id);
        $usuario = Usuario::create([
            'personal_id' => $request->personal_id,
            'password' => Hash::make($personal->codigo ?? 'Cbvp2025'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($request->input('roles')) {
            $usuario->assignRole($request->input('roles'));
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario Creado Correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function passwordreset(Usuario $usuario)
    {
        $vtUsuario = User::find($usuario->id_usuario);
        $usuario->update(['password' => Hash::make($vtUsuario->codigo)]);
        return redirect()->route('usuarios.index')
            ->with('success', 'Contraseña restablecida correctamente');
    }
}
