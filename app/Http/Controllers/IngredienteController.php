<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index()
    {
        $ingredientes = Ingrediente::all();
        return view('ingrediente.index', compact('ingredientes'));
    }

    public function create()
    {
        return view('ingrediente.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:ingredientes,nombre|max:100'
        ]);

        Ingrediente::create($request->all());
        return redirect()->route('ingredientes.index');
    }

    public function edit(Ingrediente $ingrediente)
    {
        return view('ingrediente.edit', compact('ingrediente'));
    }

    public function update(Request $request, Ingrediente $ingrediente)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:ingredientes,nombre,' . $ingrediente->id_ingrediente . ',id_ingrediente'
        ]);

        $ingrediente->update($request->all());
        return redirect()->route('ingredientes.index');
    }

    public function destroy(Ingrediente $ingrediente)
    {
        $ingrediente->delete();
        return redirect()->route('ingredientes.index');
    }
}