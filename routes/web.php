<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('login');
});

// Rutas para el controlador Usuario
Route::get('/usuario', 'App\Http\Controllers\UsuarioController@obtenerTodo');
Route::get('/usuario/{id}', 'App\Http\Controllers\UsuarioController@obtenerPorId');
Route::post('/usuario', 'App\Http\Controllers\UsuarioController@ingresar');
Route::put('/usuario/{id}', 'App\Http\Controllers\UsuarioController@editar');
Route::delete('/usuario/{id}', 'App\Http\Controllers\UsuarioController@borrar');

Route::resource('tarea', TareaController::class);

// Rutas para el controlador Estado
Route::get('/estado', 'App\Http\Controllers\EstadoController@obtenerTodo');
Route::get('/estado/{id}', 'App\Http\Controllers\EstadoController@obtenerPorId');
Route::post('/estado', 'App\Http\Controllers\EstadoController@ingresar');
Route::put('/estado/{id}', 'App\Http\Controllers\EstadoController@editar');
Route::delete('/estado/{id}', 'App\Http\Controllers\EstadoController@borrar');

// Ruta para el inicio de sesión
Route::get('/login', function () {
    return view('login');
})->name('login');

// Ruta para redirigir al registro
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [usuarioController::class, 'registrarUsuario'])->name('register');


Route::post('/login', [usuarioController::class, 'login']);

Route::post('/logout', [usuarioController::class, 'logout'])->name('logout');

// Ruta para el home (puedes ajustarla según la estructura de tu aplicación)
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');