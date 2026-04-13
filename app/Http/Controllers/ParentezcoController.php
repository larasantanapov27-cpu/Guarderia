<?php

namespace App\Http\Controllers;

use App\Models\Parentezco; // Asegúrate de tener el modelo creado
use Illuminate\Http\Request;

class ParentezcoController extends Controller
{
    /**
     * Muestra la lista de parentescos.
     */
    public function index()
    {
        // Obtenemos todos los registros de la tabla parentezcos
        $parentezcos = Parentezco::all();

        // Retornamos la vista (ajusta la ruta de la carpeta si es necesario)
        return view('parentezco.index', compact('parentezcos'));
    }

    /**
     * Muestra el formulario para crear un nuevo parentesco.
     */
    public function create()
    {
        return view('parentezco.create');
    }

    /**
     * Almacena un nuevo parentesco en la base de datos.
     */
    public function store(Request $request)
    {
        // Validamos que el nombre sea obligatorio (opcional pero recomendado)
        $request->validate([
            'nombre' => 'required|max:100|unique:parentezcos,nombre'
        ]);

        Parentezco::create($request->all());

        return redirect()->route('parentezcos.index');
    }

    /**
     * Muestra un parentesco específico (usualmente no se usa para tablas simples).
     */
    public function show(Parentezco $parentezco)
    {
        return view('parentezco.show', compact('parentezco'));
    }

    /**
     * Muestra el formulario para editar un parentesco.
     */
    public function edit(Parentezco $parentezco)
    {
        return view('parentezco.edit', compact('parentezco'));
    }

    /**
     * Actualiza el parentesco en la base de datos.
     */
    public function update(Request $request, Parentezco $parentezco)
    {
        // Validamos los datos antes de actualizar
        $request->validate([
            'nombre' => 'required|max:100|unique:parentezcos,nombre,' . $parentezco->id_parentezco . ',id_parentezco'
        ]);

        $parentezco->update($request->all());

        return redirect()->route('parentezcos.index');
    }

    /**
     * Elimina el parentesco de la base de datos.
     */
    public function destroy(Parentezco $parentezco)
    {
        $parentezco->delete();

        return redirect()->route('parentezcos.index');
    }
}