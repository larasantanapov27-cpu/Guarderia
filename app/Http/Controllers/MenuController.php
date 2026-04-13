<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = DB::table('menus')
            ->join('platos', 'menus.id_plato', '=', 'platos.id_plato')
            ->join('ingredientes', 'menus.id_ingrediente', '=', 'ingredientes.id_ingrediente')
            ->select(
                'menus.id_menu', 
                'platos.nombre as plato_nombre', // Cambiado para mayor claridad
                'ingredientes.nombre as ingrediente_nombre' // Cambiado para mayor claridad
            )
            ->get();

        return view('menu.index', compact('menus')); // Carpeta en singular
    }

    public function create()
    {
        $ingredientes = DB::table('ingredientes')->get();
        $platos = DB::table('platos')->get();
        
        return view('menu.create', compact('platos', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_plato' => 'required|exists:platos,id_plato',
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente',
        ]);

        Menu::create([
            'id_plato' => $request->id_plato,
            'id_ingrediente' => $request->id_ingrediente,
        ]);

        return redirect()->route('menus.index')
                         ->with('success', 'Ingrediente asignado al plato correctamente');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $ingredientes = DB::table('ingredientes')->get();
        $platos = DB::table('platos')->get();

        return view('menu.edit', compact('menu', 'platos', 'ingredientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_plato' => 'required|exists:platos,id_plato',
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente',
        ]);

        $menu = Menu::findOrFail($id);
        // Usamos update con los campos específicos para evitar errores de id_menu
        $menu->update([
            'id_plato' => $request->id_plato,
            'id_ingrediente' => $request->id_ingrediente
        ]);

        return redirect()->route('menus.index')
                         ->with('success', 'Menú actualizado correctamente');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')
                         ->with('success', 'Relación eliminada correctamente');
    }
}