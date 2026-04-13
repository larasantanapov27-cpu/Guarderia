<?php

namespace App\Http\Controllers;

use App\Models\RegistroComida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroComidaController extends Controller
{
    /**
     * Muestra el listado de comidas con nombres de niños y platos.
     */
    public function index()
    {
        $registros = DB::table('registro_comidas')
            ->join('ninios', 'registro_comidas.id_ninio', '=', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->join('platos', 'registro_comidas.id_plato', '=', 'platos.id_plato')
            ->select(
                'registro_comidas.*', 
                'personas.nom', 'personas.ap', 
                'platos.nombre as nombre_plato'
            )
            ->get();

        return view('registro_comida.index', compact('registros'));
    }

    /**
     * Prepara el formulario de creación.
     */
    public function create()
    {
        // Traemos a los niños con su nombre real (desde la tabla personas)
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();
            
        $platos = DB::table('platos')->get();

        return view('registro_comida.create', compact('ninios', 'platos'));
    }

    /**
     * Almacena el registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ninio' => 'required',
            'id_plato' => 'required',
            'fecha'    => 'required',
            'cantidad' => 'required|integer'
        ]);

        // id_registrocomida es AUTO_INCREMENT en tu SQL, no es necesario enviarlo
        RegistroComida::create([
            'id_ninio' => $request->id_ninio,
            'id_plato' => $request->id_plato,
            'fecha'    => $request->fecha,
            'cantidad' => $request->cantidad
        ]);

        return redirect()->route('registro_comidas.index')
            ->with('success', 'Registro de comida guardado exitosamente');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $registro_comida = RegistroComida::findOrFail($id);
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();
            
        $platos = DB::table('platos')->get();

        return view('registro_comida.edit', compact('registro_comida', 'ninios', 'platos'));
    }

    /**
     * Actualiza el registro existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ninio' => 'required',
            'id_plato' => 'required',
            'fecha'    => 'required',
            'cantidad' => 'required|integer'
        ]);

        $registro = RegistroComida::findOrFail($id);
        $registro->update($request->all());

        return redirect()->route('registro_comidas.index')
            ->with('success', 'Registro actualizado correctamente');
    }

    /**
     * Elimina el registro.
     */
    public function destroy($id)
    {
        $registro = RegistroComida::findOrFail($id);
        $registro->delete();

        return redirect()->route('registro_comidas.index')
            ->with('success', 'Registro eliminado');
    }
}