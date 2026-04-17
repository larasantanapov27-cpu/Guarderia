<?php

namespace App\Http\Controllers;

use App\Models\BajaNinio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BajaNinioController extends Controller
{
    /**
     * Muestra la lista de bajas.
     */
    public function index()
    {
        // Usamos joins manuales para traer la matrícula y el nombre desde la tabla personas
        $bajas = BajaNinio::join('ninios', 'baja_ninios.id_ninio', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->select(
                'baja_ninios.id_baja',
                'baja_ninios.motivo',
                'baja_ninios.fecha',
                'ninios.matricula',
                'personas.nom',
                'personas.ap',
                'personas.am'
            )
            ->get();

        return view('baja_ninio.index', compact('bajas'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        // Obtenemos los niños y sus nombres personales
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap', 'personas.am')
            ->get();

        return view('baja_ninio.create', compact('ninios'));
    }

    /**
     * Guarda la baja.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'motivo'   => 'required|string|max:100',
            'fecha'    => 'required'
        ]);

        BajaNinio::create($request->all());

        return redirect()->route('baja_ninios.index')
            ->with('success', 'Baja registrada correctamente');
    }

    /**
     * Formulario de edición.
     */
    public function edit($id)
    {
        $baja = BajaNinio::findOrFail($id);
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap', 'personas.am')
            ->get();

        return view('baja_ninio.edit', compact('baja', 'ninios'));
    }

    /**
     * Actualiza el registro.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'motivo'   => 'required|string|max:100',
            'fecha'    => 'required'
        ]);

        $baja = BajaNinio::findOrFail($id);
        $baja->update($request->all());

        return redirect()->route('baja_ninios.index')
            ->with('success', 'Registro actualizado correctamente');
    }

    /**
     * Elimina el registro.
     */
    public function destroy($id)
    {
        $baja = BajaNinio::findOrFail($id);
        $baja->delete();

        return redirect()->route('baja_ninios.index')
            ->with('success', 'Registro eliminado');
    }
}