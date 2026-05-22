<?php

namespace App\Http\Controllers;

use App\Models\RegistroCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroCuentaController extends Controller
{
    /**
     * Muestra el listado de cuentas con el nombre del familiar responsable.
     */
    public function index()
    {
        // Usamos la sintaxis de joins sin el '=' para mantener tu estilo
        $cuentas = RegistroCuenta::join('familiares', 'registro_cuentas.id_fam', 'familiares.id_fam')
            ->join('personas', 'familiares.id_persona', 'personas.id_persona')
            ->select(
                'registro_cuentas.id_regcuenta as id_regcuenta', // Alias para tu vista
                'registro_cuentas.cuenta',
                'personas.nom as nombre_fam',
                'personas.ap as apellido_fam'
            )
            ->get();

        return view('registro_cuenta.index', compact('cuentas'));
    }

    /**
     * Prepara el formulario de creación.
     */
    public function create()
    {
        // Traemos a los familiares con su nombre real desde la tabla personas
        $familiares = DB::table('familiares')
            ->join('personas', 'familiares.id_persona', 'personas.id_persona')
            ->select('familiares.id_fam', 'personas.nom', 'personas.ap')
            ->get();

        return view('registro_cuenta.create', compact('familiares'));
    }

    /**
     * Almacena el registro de la cuenta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_fam' => 'required|exists:familiares,id_fam',
            'cuenta' => 'required|numeric|unique:registro_cuentas,cuenta'
        ]);

        // id_regcuenta es la PK en tu SQL
        RegistroCuenta::create($request->all());

        return redirect()->route('registro_cuentas.index')
            ->with('success', 'Cuenta registrada correctamente');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        // Buscamos por la PK id_regcuenta definida en tu modelo
        $registro_cuenta = RegistroCuenta::findOrFail($id);
        
        $familiares = DB::table('familiares')
            ->join('personas', 'familiares.id_persona', 'personas.id_persona')
            ->select('familiares.id_fam', 'personas.nom', 'personas.ap')
            ->get();

        return view('registro_cuenta.edit', compact('registro_cuenta', 'familiares'));
    }

    /**
     * Actualiza el registro.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_fam' => 'required|exists:familiares,id_fam',
            'cuenta' => 'required|numeric'
        ]);

        $registro = RegistroCuenta::findOrFail($id);
        $registro->update($request->all());

        return redirect()->route('registro_cuentas.index')
            ->with('success', 'Cuenta actualizada correctamente');
    }

    /**
     * Elimina la cuenta.
     */
    public function destroy($id)
    {
        $registro = RegistroCuenta::findOrFail($id);
        $registro->delete();

        return redirect()->route('registro_cuentas.index')
            ->with('success', 'Cuenta eliminada');
    }
}