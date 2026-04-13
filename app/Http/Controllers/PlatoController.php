<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\Http\Request;

class PlatoController extends Controller
{
    public function index()
    {
        $platos = Plato::all();
        return view('plato.index', compact('platos'));
    }

    public function create()
    {
        return view('plato.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:platos,nombre|max:100',
            'precio' => 'required|numeric|min:0'
        ]);

        Plato::create($request->all());
        return redirect()->route('platos.index');
    }

    public function edit(Plato $plato)
    {
        return view('plato.edit', compact('plato'));
    }

    public function update(Request $request, Plato $plato)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:platos,nombre,' . $plato->id_plato . ',id_plato',
            'precio' => 'required|numeric|min:0'
        ]);

        $plato->update($request->all());
        return redirect()->route('platos.index');
    }

    public function destroy(Plato $plato)
    {
        $plato->delete();
        return redirect()->route('platos.index');
    }
}