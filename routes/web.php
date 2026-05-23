<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VistaRapidaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController; 



// Rutas de Autenticación (Login)
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Nuevas Rutas para Registro de Usuarios
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::middleware(['auth'])->group(function () {

    // Ruta raíz redirige al inicio protegido
    Route::get('/', [VistaRapidaController::class, 'index'])->name('vista_rapida.index');

    // Recursos de la Guardería
    Route::resource('abonos', 'App\Http\Controllers\AbonoController');
    Route::resource('alergias', 'App\Http\Controllers\AlergiaController');
    Route::resource('familiares', 'App\Http\Controllers\FamiliaresController');
    Route::resource('menus', 'App\Http\Controllers\MenuController');
    Route::resource('ninios', 'App\Http\Controllers\NinioController');
    Route::resource('personas', 'App\Http\Controllers\PersonaController');
    Route::resource('registro_comidas', 'App\Http\Controllers\RegistroComidaController');
    Route::resource('registro_cuentas', 'App\Http\Controllers\RegistroCuentaController');
    Route::resource('baja_ninios', 'App\Http\Controllers\BajaNinioController');
    Route::resource('centros', 'App\Http\Controllers\CentrosController');
    Route::resource('ingredientes', 'App\Http\Controllers\IngredienteController');
    Route::resource('parentezcos', 'App\Http\Controllers\ParentezcoController');
    Route::resource('platos', 'App\Http\Controllers\PlatoController');
    Route::resource('vista_rapida', 'App\Http\Controllers\VistaRapidaController');
    
});