<?php

namespace App\Http\Controllers;

use App\Models\BajaNinio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BajaNinioController extends Controller
{
    /**
     * Muestra el listado de bajas.
     */
    public function index()
    {
        $bajas = DB::table('baja_ninios')
            ->join('ninios', 'baja_ninios.id_ninio', '=', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
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

        // Carpeta en singular: baja_ninio
        return view('baja_ninio.index', compact('bajas'));
    }

    /**
     * Formulario para crear.
     */
    public function create()
    {
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap', 'personas.am')
            ->get();

        // Carpeta en singular: baja_ninio
        return view('baja_ninio.create', compact('ninios'));
    }

    /**
     * Guardar registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'motivo'   => 'required|string|max:100',
            'fecha'    => 'required'
        ]);

        BajaNinio::create([
            'id_ninio' => $request->id_ninio,           
            'motivo'   => $request->motivo,
            'fecha'    => $request->fecha 
        ]);

        return redirect()->route('baja_ninios.index')
            ->with('success', 'Baja registrada correctamente');
    }

    /**
     * Formulario de edición.
     */
    public function edit($id)
    {
        // Busca por id_baja (definido en el modelo)
        $baja = BajaNinio::findOrFail($id);

        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap', 'personas.am')
            ->get();

        // Carpeta en singular: baja_ninio
        return view('baja_ninio.edit', compact('baja', 'ninios'));
    }

    /**
     * Actualizar registro.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'motivo'   => 'required|string|max:100',
            'fecha'    => 'required'
        ]);

        $baja = BajaNinio::findOrFail($id);
        
        $baja->update([
            'id_ninio' => $request->id_ninio,
            'motivo'   => $request->motivo,
            'fecha'    => $request->fecha,
        ]);

        return redirect()->route('baja_ninios.index')
            ->with('success', 'Registro de baja actualizado correctamente');
    }

    /**
     * Eliminar registro.
     */
    public function destroy($id)
    {
        $baja = BajaNinio::findOrFail($id);
        $baja->delete();

        return redirect()->route('baja_ninios.index')
            ->with('success', 'Registro de baja eliminado');
    }
}