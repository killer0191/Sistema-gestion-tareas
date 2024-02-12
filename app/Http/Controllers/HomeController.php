<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Obtener todas las tareas del usuario actualmente autenticado
        $tareas = Tarea::where('idUsuarioF', $userId)->get();

        return view('home', ['tareas' => $tareas]);
    }
}