<?php

namespace App\Http\Controllers;

use App\Models\Menu; // Asegúrate de que el modelo se llame Menu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::join('platos', 'menus.id_plato', 'platos.id_plato')
            ->join('ingredientes', 'menus.id_ingrediente', 'ingredientes.id_ingrediente')
            ->select(
                'menus.id_menu',
                'platos.nombre as nombre_plato',
                'ingredientes.nombre as nombre_ingrediente'
            )
            ->get();

        return view('menu.index', compact('menus'));
    }

    public function create()
    {
        $platos = DB::table('platos')->get();
        $ingredientes = DB::table('ingredientes')->get();
        return view('menu.create', compact('platos', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_plato' => 'required|exists:platos,id_plato',
            'id_ingrediente' => 'required|exists:ingredientes,id_ingrediente'
        ]);

        Menu::create($request->all());

        return redirect()->route('menus.index')->with('success', 'Plato configurado en el menú');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Relación eliminada del menú');
    }
}