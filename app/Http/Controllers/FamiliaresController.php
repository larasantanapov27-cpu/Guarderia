<?php

namespace App\Http\Controllers;

use App\Models\RegistroComida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroComidaController extends Controller
{
    /**
     * Muestra el historial de comidas.
     */
    public function index()
    {
        // Unimos con ninios -> personas (para el nombre) y con platos
        $registros = RegistroComida::join('ninios', 'registro_comidas.id_ninio', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->join('platos', 'registro_comidas.id_plato', 'platos.id_plato')
            ->select(
                'registro_comidas.id_regcomida',
                'registro_comidas.fecha',
                'registro_comidas.cantidad',
                'ninios.matricula',
                'personas.nom as nombre_ninio',
                'personas.ap as apellido_ninio',
                'platos.nombre as nombre_plato'
            )
            ->get();

        return view('registro_comida.index', compact('registros'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        // Datos para los selects del formulario
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap')
            ->get();

        $platos = DB::table('platos')->select('id_plato', 'nombre')->get();

        return view('registro_comida.create', compact('ninios', 'platos'));
    }

    /**
     * Guarda el registro de comida.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'id_plato' => 'required|exists:platos,id_plato',
            'fecha'    => 'required',
            'cantidad' => 'required|numeric'
        ]);

        RegistroComida::create($request->all());

        return redirect()->route('registro_comidas.index')
            ->with('success', 'Registro de comida guardado correctamente');
    }

    /**
     * Formulario de edición.
     */
    public function edit($id)
    {
        $registro = RegistroComida::findOrFail($id);
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->select('ninios.id_ninio', 'ninios.matricula', 'personas.nom', 'personas.ap')
            ->get();

        $platos = DB::table('platos')->select('id_plato', 'nombre')->get();

        return view('registro_comida.edit', compact('registro', 'ninios', 'platos'));
    }

    /**
     * Actualiza el registro.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ninio' => 'required|exists:ninios,id_ninio',
            'id_plato' => 'required|exists:platos,id_plato',
            'fecha'    => 'required',
            'cantidad' => 'required|numeric'
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
            ->with('success', 'Registro eliminado correctamente');
    }
}