<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \DB;

class usuarioController extends Controller
{
    public function obtenerTodo()
    {
        return User::all();
    }

    public function obtenerPorId($id)
    {
        return User::findOrFail($id);
    }

    public function ingresar(Request $request)
    {
        return User::create($request->all());
    }

    public function editar(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->update($request->all());
        return $usuario;
    }

    public function borrar($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return 204;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->withInput($request->only('email'));
    }
public function registrarUsuario(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:50',
        'email' => 'required|email|max:50|unique:users',
        'password' => 'required|string|max:100',
    ]);

    $hashedPassword = Hash::make($request->password);

    $usuario = new User();
    $usuario->nombre = $request->nombre; // Asigna el nombre
    $usuario->email = $request->email;
    $usuario->password = $hashedPassword;

    $usuario->save();

    return redirect()->route('home')->with('success', 'Usuario registrado correctamente');
}
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
}

}