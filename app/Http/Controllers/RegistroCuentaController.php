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
        $cuentas = RegistroCuenta::join('familiares', 'registro_cuentas.id_fam', 'familiares.id_fam')
            ->join('personas', 'familiares.id_persona', 'personas.id_persona')
            ->select(
                'registro_cuentas.id_regcuenta as id_regcuenta', 
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
    // Buscamos a los familiares cruzando con niños y personas para mostrar los nombres de los alumnos
    $ninios = DB::table('familiares')
        ->join('ninios', 'familiares.id_ninio', 'ninios.id_ninio')
        ->join('personas', 'ninios.id_persona', 'personas.id_persona')
        ->select('familiares.id_fam', 'personas.nom', 'personas.ap', 'personas.am')
        ->get();

    return view('registro_cuenta.create', compact('ninios'));
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

        RegistroCuenta::create($request->all());

        return redirect()->route('registro_cuentas.index')
            ->with('success', 'Cuenta registrada correctamente');
    }

    /**
     * Muestra el formulario de edición.
     * ¡AQUÍ CORREGIMOS EL ERROR DE LA VARIABLE $ninios!
     */
    public function edit($id)
    {
        // 1. Buscamos la cuenta que se va a editar
        $registro_cuenta = RegistroCuenta::findOrFail($id);
        
        // 2. Traemos a los familiares vinculados con el nombre de su respectivo Niño/Alumno
        // Cruzamos 'familiares' -> 'ninios' -> 'personas' para pintar el select de forma humana
        $ninios = DB::table('familiares')
            ->join('ninios', 'familiares.id_ninio', 'ninios.id_ninio')
            ->join('personas', 'ninios.id_persona', 'personas.id_persona')
            ->select(
                'familiares.id_fam', // Mandamos el id_fam porque es lo que guarda tu formulario
                'personas.nom', 
                'personas.ap', 
                'personas.am'
            )
            ->get();

        // 3. Enviamos todas las variables requeridas (Incluyendo $ninios que causaba el error)
        return view('registro_cuenta.edit', compact('registro_cuenta', 'ninios'));
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