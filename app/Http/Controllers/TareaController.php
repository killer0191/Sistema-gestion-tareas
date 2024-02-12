<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;
use \DB;
use Psy\Readline\Hoa\Console;

class TareaController extends Controller
{
    public function obtenerTodo()
{
    $userId = Auth::id();
    $tareas = Tarea::where('idUsuarioF', $userId)->get();
    return view('home', ['tareas' => $tareas]);
}

    public function obtenerPorId($id)
    {
        return Tarea::findOrFail($id);
    }

public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required',
        'descripcion' => 'required',
    ]);

    $tarea = Tarea::findOrFail($id);
    $tarea->update($request->all());

    return response()->json(['message' => 'Tarea editada exitosamente', 'tarea' => $tarea]);
}


public function destroy(Tarea $tarea)
{
    $tarea->delete();
    return response()->json(['message' => 'Tarea eliminada correctamente'], 200);
}


public function create()
{
    // Mostrar el formulario de creación de tareas
    return view('create');
}

public function store(Request $request)
{
    // Validar los datos de la solicitud
    $request->validate([
        'titulo' => 'required',
        'descripcion' => 'required',
        'fechaVenc' => 'nullable|date',
        'idEstadoF' => 'nullable|numeric',
        'idUsuarioF' => 'required|numeric', // Puede que ya tengas un middleware de autenticación que garantice que el usuario está autenticado
    ]);

    // Crear una nueva tarea con los datos de la solicitud
    $tarea = new Tarea();
    $tarea->titulo = $request->titulo;
    $tarea->descripcion = $request->descripcion;
    $tarea->fechaVenc = $request->fechaVenc;
    $tarea->idEstadoF = $request->idEstadoF;
    $tarea->idUsuarioF = $request->idUsuarioF;
    $tarea->save();

    // Devolver una respuesta con los datos de la tarea creada
    return response()->json([
        'id' => $tarea->id,
        'titulo' => $tarea->titulo,
        'descripcion' => $tarea->descripcion,
        'fechaVenc' => $tarea->fechaVenc,
        'idEstadoF' => $tarea->idEstadoF,
        'idUsuarioF' => $tarea->idUsuarioF,
    ], 201);
}
}