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
        $ninios = Ninio::join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->join('centros', 'ninios.id_centro', 'centros.id_centro')
            ->select(
                'ninios.id_ninio', 
                'ninios.matricula', 
                'ninios.fecha',
                'personas.nom', 
                'personas.ap', 
                'personas.am',
                'centros.nom as centro_nombre' // Cambiado de 'nombre' a 'nom'
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
    // 1. Validación estricta de tus campos requeridos
    $request->validate([
        'matricula'  => 'required|numeric',
        'fecha'      => 'required|date',
        'id_persona' => 'required|exists:personas,id_persona',
        'id_centro'  => 'required|exists:centros,id_centro',
    ]);

    // 2. OBTENER EL ID MANUAL (Solución al error 1364)
    // Buscamos el ID más grande actual en la tabla ninios y le sumamos 1
    $ultimoId = \DB::table('ninios')->max('id_ninio');
    $nuevoId  = $ultimoId ? ($ultimoId + 1) : 1; // Si está vacía la tabla, empezamos en 1

    // 3. Insertar el registro incluyendo manualmente la Llave Primaria
    \DB::table('ninios')->insert([
        'id_ninio'   => $nuevoId, // ← Aquí le damos su valor manual requerido por tu esquema SQL
        'matricula'  => $request->matricula,
        'fecha'      => $request->fecha,
        'id_persona' => $request->id_persona,
        'id_centro'  => $request->id_centro,
    ]);

    // 4. Redireccionar al Index con tu alerta premium
    return redirect()->route('ninios.index')
        ->with('success', '¡Alumno registrado exitosamente con el ID #' . $nuevoId . '! ✨');
}

    public function edit($id)
    {
        $ninio = Ninio::findOrFail($id);
        $personas = DB::table('personas')->get();
        $centros = DB::table('centros')->get();

        return view('ninio.edit', compact('ninio', 'personas', 'centros'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
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