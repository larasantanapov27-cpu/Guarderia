<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.template');
});

Route::resource('abonos','App\Http\Controllers\AbonoController');
Route::resource('alergias','App\Http\Controllers\AlergiaController');
Route::resource('familiares','App\Http\Controllers\FamiliaresController');
Route::resource('menus','App\Http\Controllers\MenuController');
Route::resource('ninios','App\Http\Controllers\NinioController');
Route::resource('personas','App\Http\Controllers\PersonaController');
Route::resource('registro_comidas','App\Http\Controllers\RegistroComidaController');
Route::resource('registro_cuentas','App\Http\Controllers\RegistroCuentaController');
Route::resource('baja_ninios','App\Http\Controllers\BajaNinioController');
Route::resource('centros','App\Http\Controllers\CentrosController');
Route::resource('ingredientes','App\Http\Controllers\IngredienteController');
Route::resource('parentezcos','App\Http\Controllers\ParentezcoController');
Route::resource('platos','App\Http\Controllers\PlatoController');
Route::resource('templates','App\Http\Controllers\TemplateController');







