<?php

namespace App\Http\Controllers;

use App\Models\Alergia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlergiaController extends Controller
{
    public function index()
    {
        // Corregido: 'ingredientes.nombre' y alias para apellidos de personas
        $alergias = DB::table('alergias')
            ->join('ninios', 'alergias.id_ninio', '=', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->join('ingredientes', 'alergias.id_ingrediente', '=', 'ingredientes.id_ingrediente')
            ->select(
                'alergias.*', 
                'personas.nom', 
                'personas.ap', 
                'personas.am', 
                'ingredientes.nombre as nombre_ingrediente'
            )
            ->get();

        return view('alergia.index', compact('alergias'));
    }

    public function create()
    {
        // Corregido: Usamos 'ap' y 'am' que existen en tu tabla personas
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap', 'personas.am')
            ->get();

        $ingredientes = DB::table('ingredientes')->get();
        
        return view('alergia.create', compact('ninios', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente'
        ]);

        Alergia::create($request->all());

        return redirect()->route('alergias.index')->with('success', 'Alergia registrada');
    }

    public function edit($id)
    {
        $alergia = Alergia::findOrFail($id);

        // Corregido: Ajuste de nombres de columnas para el select de edición
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap', 'personas.am')
            ->get();

        $ingredientes = DB::table('ingredientes')->get();
        
        return view('alergia.edit', compact('alergia', 'ninios', 'ingredientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente'
        ]);

        $alergia = Alergia::findOrFail($id);
        $alergia->update($request->all());

        return redirect()->route('alergias.index')->with('success', 'Alergia actualizada');
    }

    public function destroy($id)
    {
        $alergia = Alergia::findOrFail($id);
        $alergia->delete();

        return redirect()->route('alergias.index')->with('success', 'Alergia eliminada');
    }
}