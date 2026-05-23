<?php

namespace App\Http\Controllers;

use App\Models\Menu; // Modelo unificado
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Muestra la composición general de menús.
     */
    public function index()
    {
        $menus = Menu::join('platos', 'menus.id_plato', '=', 'platos.id_plato')
            ->join('ingredientes', 'menus.id_ingrediente', '=', 'ingredientes.id_ingrediente')
            ->select(
                'menus.id_menu',
                'platos.nombre as nombre_plato',
                'ingredientes.nombre as nombre_ingrediente'
            )
            ->get();

        // Corregido para que apunte a la carpeta 'menus' o 'menu' según tu estructura de vistas
        return view('menu.index', compact('menus'));
    }

    /**
     * Formulario para asignar un ingrediente a un plato.
     */
    public function create()
    {
        $platos = DB::table('platos')->select('id_plato', 'nombre')->get();
        $ingredientes = DB::table('ingredientes')->select('id_ingrediente', 'nombre')->get();
        
        return view('menu.create', compact('platos', 'ingredientes'));
    }

    /**
     * Guarda la nueva relación controlando el ID manual de forma coherente.
     */
    public function store(Request $request)
    {
        // 1. Validación estricta en el Backend
        $request->validate([
            'id_plato'       => 'required|exists:platos,id_plato',
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente'
        ]);

        // 2. CÁLCULO DEL ID MANUAL (Mecanismo seguro para tablas sin AUTO_INCREMENT)
        $ultimoId = DB::table('menus')->max('id_menu');
        $nuevoId  = $ultimoId ? ($ultimoId + 1) : 1;

        // 3. Inserción explícita inyectando el ID calculado
        DB::table('menus')->insert([
            'id_menu'        => $nuevoId, // Tu llave primaria manual
            'id_plato'       => $request->id_plato,
            'id_ingrediente' => $request->id_ingrediente
        ]);

        return redirect()->route('menus.index')
            ->with('success', '¡Ingrediente asignado al plato exitosamente con el ID #' . $nuevoId . '! 🍲');
    }

    /**
     * Formulario de edición (Agregado para dar soporte a tu vista edit).
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $platos = DB::table('platos')->select('id_plato', 'nombre')->get();
        $ingredientes = DB::table('ingredientes')->select('id_ingrediente', 'nombre')->get();

        return view('menu.edit', compact('menu', 'platos', 'ingredientes'));
    }

    /**
     * Actualiza la relación en la base de datos (Agregado).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_plato'       => 'required|exists:platos,id_plato',
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        return redirect()->route('menus.index')
            ->with('success', 'La composición del plato se actualizó correctamente');
    }

    /**
     * Elimina la relación de la receta.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Relación eliminada del menú correctamente');
    }
}