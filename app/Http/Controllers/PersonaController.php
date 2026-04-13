<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $personas = Persona::all();

       // dd($personas);
        return view('persona.index', compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('persona.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        Persona::create($request->all());
        return redirect()->route('personas.index');

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        return "hola desde show";

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persona $persona)
    {
        //dd($persona);
        return view('persona.edit', compact('persona'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
       $persona->update($request->all());

       return redirect()->route('personas.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        //dd($persona);
        $persona->delete();
        return redirect()->route('personas.index');

        //
    }
}