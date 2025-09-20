<?php

namespace App\Http\Controllers\Anb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuieroSerBomberoController extends Controller
{
    public function index()
    {
        return view('anb.quiero-ser-bombero');    
    }
}
