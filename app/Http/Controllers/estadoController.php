<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\estado;
use \DB;

class estadoController extends Controller
{
    public function obtenerTodo()
    {
        return Estado::all();
    }

    public function obtenerPorId($id)
    {
        return Estado::findOrFail($id);
    }

    public function ingresar(Request $request)
    {
        return Estado::create($request->all());
    }

    public function editar(Request $request, $id)
    {
        $estado = Estado::findOrFail($id);
        $estado->update($request->all());
        return $estado;
    }

    public function borrar($id)
    {
        $estado = Estado::findOrFail($id);
        $estado->delete();
        return 204;
    }
}