<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CambiarContrasenaController extends Controller
{
    /**
     * Mostrar Formulario de Actualizacion de contraseña.
     */
    public function cambiarContrasena()
    {
        return view('auth.cambiar-contrasena');
    }

    /**
     * Metodo de Actualizacion de contraseña.
     */
    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'old_password.required' => 'El campo contraseña actual es obligatorio.',
            'new_password.required' => 'El campo nueva contraseña es obligatorio.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "La contraseña anterior no coincide!");
        }


        #Update the new Password
        User::where('id_user', auth()->user()->id_user)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Contraseña cambiada exitosamente!");
    }
}
