<?php

namespace App\Http\Controllers;

use App\Models\Familiar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamiliaresController extends Controller
{
    public function index()
    {
        $familiares = DB::table('familiares')
            ->join('personas as p_fam', 'familiares.id_persona', '=', 'p_fam.id_persona')
            ->join('parentezcos', 'familiares.id_parentezco', '=', 'parentezcos.id_parentezco')
            ->join('ninios', 'familiares.id_ninio', '=', 'ninios.id_ninio')
            ->join('personas as p_ninio', 'ninios.id_persona', '=', 'p_ninio.id_persona')
            ->select(
                'familiares.*',
                'p_fam.nom as nom_fam', 'p_fam.ap as ap_fam',
                'parentezcos.nombre as parentesco',
                'p_ninio.nom as nom_ninio', 'p_ninio.ap as ap_ninio'
            )
            ->get();

        return view('familiar.index', compact('familiares'));
    }

    public function create()
    {
        $personas = DB::table('personas')->get();
        $parentezcos = DB::table('parentezcos')->get();
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();

        return view('familiar.create', compact('personas', 'parentezcos', 'ninios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_persona' => 'required',
            'DNI' => 'required|unique:familiares,DNI',
            'dir' => 'required|max:100',
            'id_parentezco' => 'required',
            'id_ninio' => 'required'
        ]);

        Familiares::create($request->all());

        return redirect()->route('familiares.index')->with('success', 'Familiar registrado');
    }

    // --- MÉTODOS AÑADIDOS ---

    public function edit($id)
    {
        // Buscamos el familiar por su ID primario 'id_fam'
        $familiar = Familiar::findOrFail($id);

        $personas = DB::table('personas')->get();
        $parentezcos = DB::table('parentezcos')->get();
        
        $ninios = DB::table('ninios')
            ->join('personas', 'ninios.id_persona', '=', 'personas.id_persona')
            ->select('ninios.id_ninio', 'personas.nom', 'personas.ap')
            ->get();

        return view('familiar.edit', compact('familiar', 'personas', 'parentezcos', 'ninios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_persona' => 'required',
            // Validamos que el DNI sea único, ignorando el registro actual por su ID
            'DNI' => 'required|unique:familiares,DNI,' . $id . ',id_fam',
            'dir' => 'required|max:100',
            'id_parentezco' => 'required',
            'id_ninio' => 'required'
        ]);

        $familiar = Familiar::findOrFail($id);
        $familiar->update($request->all());

        return redirect()->route('familiares.index')->with('success', 'Familiar actualizado');
    }

    public function destroy($id)
    {
        $familiar = Familiar::findOrFail($id);
        $familiar->delete();

        return redirect()->route('familiares.index')->with('success', 'Familiar eliminado');
    }
}