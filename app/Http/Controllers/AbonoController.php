<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbonoController extends Controller
{
    /**
     * Muestra la lista de abonos.
     */
    public function index()
    {
        // Traemos todos los abonos para la tabla del index
        $abonos = Abono::all();
        return view('abono.index', compact('abonos'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        // Obtenemos las cuentas para el select del formulario
        $cuentas = DB::table('registro_cuentas')->get();
        return view('abono.create', compact('cuentas'));
    }

    /**
     * Guarda el nuevo abono.
     */
    public function store(Request $request)
    {
        // Es recomendable validar los datos antes de guardar
        $request->validate([
            'cantidad' => 'required|numeric',
            'fecha' => 'required',
            'id_regcuenta' => 'required'
        ]);

        Abono::create($request->all());

        return redirect()->route('abonos.index')
            ->with('success', 'Abono guardado correctamente');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        // Buscamos el abono por su ID manual ya que usas llaves personalizadas
        $abono = Abono::findOrFail($id);
        $cuentas = DB::table('registro_cuentas')->get();
        
        return view('abono.edit', compact('abono', 'cuentas'));
    }

    /**
     * Actualiza el abono en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|numeric',
            'fecha' => 'required',
            'id_regcuenta' => 'required'
        ]);

        $abono = Abono::findOrFail($id);
        $abono->update($request->all());

        return redirect()->route('abonos.index')
            ->with('success', 'Abono actualizado correctamente');
    }

    /**
     * Elimina el abono.
     */
    public function destroy($id)
    {
        $abono = Abono::findOrFail($id);
        $abono->delete();

        return redirect()->route('abonos.index')
            ->with('success', 'Abono eliminado correctamente');
    }
}