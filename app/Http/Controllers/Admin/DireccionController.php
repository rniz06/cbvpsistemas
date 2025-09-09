<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    // Protegido directamente por rol SuperAdmin

    public function index()
    {
        return view('admin.direcciones.index');
    }
}
