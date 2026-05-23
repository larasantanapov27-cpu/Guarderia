<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamiliaresController extends Controller
{
    /**
     * Muestra el listado general de familiares responsables.
     */
    public function index()
    {
        // Cruzamos familiares con personas (para el tutor), ninios (para el alumno) y parentescos
        $familiares = DB::table('familiares')
            ->join('personas', 'familiares.id_persona', '=', 'personas.id_persona')
            ->join('ninios', 'familiares.id_ninio', '=', 'ninios.id_ninio')
            // Cruzamos de nuevo con personas, pero esta vez a través de la tabla ninios para sacar el nombre del alumno
            ->join('personas as p_ninio', 'ninios.id_persona', '=', 'p_ninio.id_persona')
            ->join('parentezcos', 'familiares.id_parentezco', '=', 'parentezcos.id_parentezco')
            ->select(
                'familiares.id_fam',
                'familiares.DNI',
                'familiares.dir',
                'personas.nom as nom_fam',
                'personas.ap as ap_fam',
                'parentezcos.nombre as parentesco',
                'p_ninio.nom as nom_ninio',
                'p_ninio.ap as ap_ninio'
            )
            ->get();

        return view('familiar.index', compact('familiares'));
    }

    /**
     * Formulario para registrar un nuevo familiar.
     */
    public function create()
    {
        // Traemos a las personas disponibles para asignar como tutores
        $personas = DB::table('personas')->select('id_persona', 'nom', 'ap')->get();
        
        // Traemos los tipos de parentescos cargados en la base de datos
        $parentezcos = DB::table('parentezcos')->select('id_parentezco', 'nombre')->get();

        // Traemos a los niños junto con sus nombres cruzando con personas para el select
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();

        return view('familiar.create', compact('personas', 'parentezcos', 'ninios'));
    }

    /**
     * Guarda el registro del familiar.
     * ¡AQUÍ CALCULAMOS EL ID MANUAL COHERENTE PARA TU BASE DE DATOS!
     */
    public function store(Request $request)
    {
        // 1. Validación estricta con filtros lógicos coherentes
        $request->validate([
            'id_persona'    => 'required|exists:personas,id_persona',
            'DNI'           => 'required|numeric|min:1', // El DNI debe ser real y mayor a 0
            'dir'           => 'required|string|max:100',
            'id_parentezco' => 'required|exists:parentezcos,id_parentezco',
            'id_ninio'      => 'required|exists:ninios,id_ninio',
        ]);

        // 2. CÁLCULO DEL ID MANUAL (Evita el error 1364 de campo sin valor por defecto)
        // Buscamos el ID más alto actual en la tabla familiares y le sumamos 1
        $ultimoId = DB::table('familiares')->max('id_fam');
        $nuevoId  = $ultimoId ? ($ultimoId + 1) : 1;

        // 3. Insertar el registro incluyendo manualmente la Llave Primaria
        DB::table('familiares')->insert([
            'id_fam'        => $nuevoId, // Tu PK normalizada sin AUTO_INCREMENT
            'DNI'           => $request->DNI,
            'dir'           => $request->dir,
            'id_persona'    => $request->id_persona,
            'id_parentezco' => $request->id_parentezco,
            'id_ninio'      => $request->id_ninio,
        ]);

        // 4. Redireccionar al index con tu Alerta Premium
        return redirect()->route('familiares.index')
            ->with('success', '¡Familiar registrado exitosamente con el ID #' . $nuevoId . '! ✨');
    }

    /**
     * Formulario de edición.
     */
    public function edit($id)
    {
        // Buscamos el registro específico del familiar
        $familiar = DB::table('familiares')->where('id_fam', $id)->first();
        
        if (!$familiar) {
            return redirect()->route('familiares.index')->with('error', 'El familiar no existe.');
        }

        $personas = DB::table('personas')->select('id_persona', 'nom', 'ap')->get();
        $parentezcos = DB::table('parentezcos')->select('id_parentezco', 'nombre')->get();
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();

        return view('familiar.edit', compact('familiar', 'personas', 'parentezcos', 'ninios'));
    }

    /**
     * Actualiza el registro.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_persona'    => 'required|exists:personas,id_persona',
            'DNI'           => 'required|numeric|min:1',
            'dir'           => 'required|string|max:100',
            'id_parentezco' => 'required|exists:parentezcos,id_parentezco',
            'id_ninio'      => 'required|exists:ninios,id_ninio',
        ]);

        DB::table('familiares')->where('id_fam', $id)->update([
            'DNI'           => $request->DNI,
            'dir'           => $request->dir,
            'id_persona'    => $request->id_persona,
            'id_parentezco' => $request->id_parentezco,
            'id_ninio'      => $request->id_ninio,
        ]);

        return redirect()->route('familiares.index')
            ->with('success', 'Los datos del familiar se actualizaron correctamente');
    }

    /**
     * Elimina el registro de la base de datos.
     */
    public function destroy($id)
    {
        DB::table('familiares')->where('id_fam', $id)->delete();

        return redirect()->route('familiares.index')
            ->with('success', 'El familiar ha sido eliminado de los expedientes correctamente');
    }
}