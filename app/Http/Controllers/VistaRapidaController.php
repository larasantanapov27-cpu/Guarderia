<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Centros; // Asegúrate de que coincida con tu modelo (plural o singular)

class VistaRapidaController extends Controller
{
    public function index()
    {
        $centros = Centros::all();
        return view('vista_rapida.index', compact("centros"));
    }
}