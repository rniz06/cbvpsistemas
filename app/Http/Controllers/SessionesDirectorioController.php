<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionesDirectorioController extends Controller
{
    public function sessionEnVivo()
    {
        return view('sessiones_directorio.session_en_vivo');
    }
}
