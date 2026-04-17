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
        
        /*SELECT abonos.cantidad, abonos.fecha, personas.nom AS nombre_ninio, personas_tutor.nom AS nombre_tutor, registro_cuentas.cuenta 
        FROM abonos, registro_cuentas, familiares, ninios, personas, personas AS personas_tutor 
        WHERE abonos.id_regcuenta = registro_cuentas.id_regcuenta 
        AND registro_cuentas.id_fam = familiares.id_fam 
        AND familiares.id_ninio = ninios.id_ninio 
        AND ninios.id_persona = personas.id_persona 
        AND familiares.id_persona = personas_tutor.id_persona;*/
        $abonos=Abono::join('registro_cuentas', 'abonos.id_regcuenta', 'registro_cuentas.id_regcuenta')
        ->join('familiares','registro_cuentas.id_fam','familiares.id_fam')
        ->join('ninios','familiares.id_ninio','ninios.id_ninio')
        ->join('personas','ninios.id_persona','personas.id_persona')
        ->join('personas as personas_tutor','familiares.id_persona','personas_tutor.id_persona')
        ->select('abonos.id_abono','abonos.cantidad', 'abonos.fecha', 'personas.nom AS nombre_ninio', 'personas_tutor.nom AS nombre_tutor', 'registro_cuentas.cuenta')
        ->get();
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