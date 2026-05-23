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
        $registros = RegistroComida::join('ninios', 'registro_comidas.id_ninio', '=', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->join('platos', 'registro_comidas.id_plato', '=', 'platos.id_plato')
            ->select(
                'registro_comidas.id_registrocomida as id_regcomida', 
                'registro_comidas.fecha',
                'personas.nom as nombre_ninio', 
                'personas.ap as apellido_ninio', 
                'platos.nombre as nombre_plato'
            )
            ->get();

        // Mapeado a la carpeta exacta 'registro_comida.index' según tus archivos
        return view('registro_comida.index', compact('registros'));
    }

    /**
     * Prepara el formulario de creación.
     */
    public function create()
    {
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();
            
        $platos = DB::table('platos')->select('id_plato', 'nombre')->get();

        return view('registro_comida.create', compact('ninios', 'platos'));
    }

    /**
     * Almacena el registro delegando el ID al AUTO_INCREMENT de MySQL.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'id_plato' => 'required|exists:platos,id_plato',
            'fecha'    => 'required|date'
        ]);

        // Guardamos de manera limpia. Inyectamos cantidad como 1 para cumplir con el esquema de la DB
        $registro = RegistroComida::create([
            'id_ninio' => $request->id_ninio,
            'id_plato' => $request->id_plato,
            'fecha'    => $request->fecha,
            'cantidad' => 1 
        ]);

        return redirect()->route('registro_comidas.index')
            ->with('success', '¡Consumo de alimento registrado exitosamente con el ID #' . $registro->id_registrocomida . '! 🍏');
    }

    /**
     * Muestra el formulario de edición sincronizado con la vista.
     */
    public function edit($id)
    {
        $registroComida = RegistroComida::findOrFail($id);
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();
            
        $platos = DB::table('platos')->select('id_plato', 'nombre')->get();

        return view('registro_comida.edit', compact('registroComida', 'ninios', 'platos'));
    }

    /**
     * Actualiza el registro existente usando asignación masiva segura.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'id_plato' => 'required|exists:platos,id_plato',
            'fecha'    => 'required|date'
        ]);

        $registro = RegistroComida::findOrFail($id);
        
        $registro->update([
            'id_ninio' => $request->id_ninio,
            'id_plato' => $request->id_plato,
            'fecha'    => $request->fecha,
            'cantidad' => 1
        ]);

        return redirect()->route('registro_comidas.index')
            ->with('success', 'El registro de alimentación se actualizó correctamente');
    }

    /**
     * Elimina el registro del historial.
     */
    public function destroy($id)
    {
        $registro = RegistroComida::findOrFail($id);
        $registro->delete();

        return redirect()->route('registro_comidas.index')
            ->with('success', 'El registro de comida ha sido eliminado del historial correctamente');
    }
}