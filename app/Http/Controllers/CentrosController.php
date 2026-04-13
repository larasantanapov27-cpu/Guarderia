<?php

namespace App\Http\Controllers;

use App\Models\Centros;
use Illuminate\Http\Request;

class CentrosController extends Controller
{
    public function index()
    {
        $centros = Centros::all();
        return view('centro.index', compact('centros'));
    }

    public function create()
    {
        return view('centro.create');
    }

    public function store(Request $request)
    {
        Centros::create($request->all());
        return redirect()->route('centros.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
  
        $centro = Centros::where('id_centro', $id)->firstOrFail();
        return view('centro.edit', compact('centro'));
    }

    public function update(Request $request, $id)
    {
        $centro = Centros::findOrFail($id);
        $centro->update($request->all());
        return redirect()->route('centros.index');
    }

    public function destroy($id)
    {
        $centro = Centros::findOrFail($id);
        $centro->delete();
        return redirect()->route('centros.index');
    }
}