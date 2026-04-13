<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\RegistroCuenta; // Asegúrate de que el nombre coincida con el modelo
use Illuminate\Http\Request;

class RegistroCuentaController extends Controller
{
    /**
     * Muestra el listado de cuentas con el nombre del niño.
     */
    public function index()
    {
        $cuentas = DB::table('registro_cuentas')
            ->join('ninios', 'registro_cuentas.id_ninio', '=', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('registro_cuentas.*', 'personas.nom', 'personas.ap')
            ->get();

        return view('registro_cuenta.index', compact('cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // SEGÚN TU SQL: La relación es con NIÑOS, no familiares.
        // Obtenemos los niños y su nombre real para el selector.
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();

        return view('registro_cuenta.create', compact('ninios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ninio' => 'required',
            'monto' => 'required|numeric',
            'mes' => 'required'
        ]);

        // id_regcuenta es AUTO_INCREMENT, no se envía.
        RegistroCuenta::create([
            'monto'    => $request->monto,
            'mes'      => $request->mes,
            'id_ninio' => $request->id_ninio
        ]);

        return redirect()->route('registro_cuentas.index')
            ->with('success', 'Cuenta registrada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Usamos findOrFail con el ID ya que tu modelo define id_regcuenta
        $registro_cuenta = RegistroCuenta::findOrFail($id);
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();

        return view('registro_cuenta.edit', compact('registro_cuenta', 'ninios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ninio' => 'required',
            'monto' => 'required|numeric',
            'mes' => 'required'
        ]);

        $registro = RegistroCuenta::findOrFail($id);
        $registro->update($request->all());

        return redirect()->route('registro_cuentas.index')
            ->with('success', 'Cuenta actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $registro = RegistroCuenta::findOrFail($id);
        $registro->delete();

        return redirect()->route('registro_cuentas.index')
            ->with('success', 'Cuenta eliminada');
    }
}