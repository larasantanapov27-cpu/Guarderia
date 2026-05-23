<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Procesa y guarda el nuevo usuario administrativo.
     */
    public function store(Request $request)
    {
        // 1. Validación estricta en el Servidor (Seguridad extra)
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^([^0-9]*)$/'], // No permite números
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Correo único en la tabla
            'password' => ['required', 'string', 'min:6', 'confirmed'], // Exige que coincida con password_confirmation
        ], [
            // Mensajes personalizados en español por si falla algo
            'name.regex' => 'El nombre completo no puede contener números.',
            'email.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        // 2. Crear el usuario en la Base de Datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptación segura de la contraseña
        ]);

        // 3. Iniciar sesión automáticamente tras el registro (Opcional)
        Auth::login($user);

        // 4. Redireccionar al Inicio Protegido de KiddoSpace
        return redirect()->route('vista_rapida.index');
    }
}