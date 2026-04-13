<?php

namespace App\Http\Controllers;

use App\Models\Ninio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NinioController extends Controller
{
    /**
     * Muestra la lista de niños con sus nombres y centros.
     */
    public function index()
    {
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->join('centros', 'ninios.id_centro', '=', 'centros.id_centro')
            ->select(
                'ninios.id_ninio', 
                'ninios.matricula', 
                'ninios.fecha',
                'personas.nom', 
                'personas.ap', 
                'personas.am',
                'centros.nom as centro_nombre' // Alias estándar para la vista
            )
            ->get();

        return view('ninio.index', compact('ninios'));
    }

    public function create()
    {
        $personas = DB::table('personas')->get();
        $centros = DB::table('centros')->get();
        return view('ninio.create', compact('personas', 'centros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula'  => 'required|integer|unique:ninios,matricula',
            'fecha'      => 'required|date', 
            'id_persona' => 'required|exists:personas,id_persona',
            'id_centro'  => 'required|exists:centros,id_centro'
        ]);

        Ninio::create($request->all());

        return redirect()->route('ninios.index')
            ->with('success', 'Niño registrado correctamente');
    }

    public function edit($id)
    {
        // Importante: FindOrFail usa la PK id_ninio definida en el modelo
        $ninio = Ninio::findOrFail($id);
        $personas = DB::table('personas')->get();
        $centros = DB::table('centros')->get();

        return view('ninio.edit', compact('ninio', 'personas', 'centros'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Corrección: Validamos unicidad de matrícula ignorando el registro actual por su PK id_ninio
            'matricula'  => "required|integer|unique:ninios,matricula,$id,id_ninio",
            'fecha'      => 'required|date',
            'id_persona' => 'required|exists:personas,id_persona',
            'id_centro'  => 'required|exists:centros,id_centro'
        ]);

        $ninio = Ninio::findOrFail($id);
        $ninio->update($request->all());

        return redirect()->route('ninios.index')
            ->with('success', 'Datos del niño actualizados');
    }

    public function destroy($id)
    {
        $ninio = Ninio::findOrFail($id);
        $ninio->delete();

        return redirect()->route('ninios.index')
            ->with('success', 'Niño eliminado del sistema');
    }
}