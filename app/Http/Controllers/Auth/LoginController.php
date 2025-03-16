<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Models\Personal\Categoria;
use App\Models\User;
use App\Models\Vistas\VtUsuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Retornar la vista de autenticación.
     */
    public function index()
    {
        $categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();
        return view('auth.login', compact('categorias'));
    }

    /**
     * Autenticar al usuario en la aplicación.
     */
    public function login(LoginRequest $request)
    {
        $tipoEntrada = filter_var($request->usuario, FILTER_VALIDATE_EMAIL) ? 'email' : 'codigo';

        switch ($tipoEntrada) {
            case 'email':
                // Autenticación por email
                if (Auth::attempt(['email' => $request->usuario, 'password' => $request->password])) {
                    return redirect()->route('home');
                }
                break;

            case 'codigo':
                // Autenticación por código
                $usuario = User::where('categoria_id', $request->categoria_id)
                    ->where('codigo', $request->usuario)
                    ->first();

                if ($usuario && Hash::check($request->password, $usuario->password)) {
                    Auth::login($usuario);
                    return redirect()->route('home');
                }
                break;
        }

        // Si llegamos aquí, la autenticación falló
        return back()->withErrors(['error' => 'Credenciales inválidas']);
    }

    /**
     * Cerrar la sesión del usuario de la aplicación.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
