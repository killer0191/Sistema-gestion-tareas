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
        'password' => 'required|string|max:100|confirmed', // Asegura que la confirmación de la contraseña coincida
    ]);

    // Verifica si las contraseñas coinciden
    if ($request->password !== $request->password_confirmation) {
        return redirect()->back()->withErrors(['password_confirmation' => 'Las contraseñas no coinciden.'])->withInput($request->except('password', 'password_confirmation'));
    }

    // Verifica si ya existe un usuario con el mismo correo electrónico
    if (User::where('email', $request->email)->exists()) {
        return redirect()->back()->withErrors(['email' => 'Ya existe un usuario con este correo electrónico.'])->withInput($request->except('password', 'password_confirmation'));
    }

    $hashedPassword = Hash::make($request->password);

    $usuario = new User();
    $usuario->nombre = $request->nombre; // Asigna el nombre
    $usuario->email = $request->email;
    $usuario->password = $hashedPassword;

    // Intenta guardar el usuario
    if ($usuario->save()) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }else{
          redirect()->route('register');
        }

    } else {
        // En caso de error al guardar el usuario, redirige al usuario al registro nuevamente con un mensaje de error
        return redirect()->route('register')->withErrors(['general' => 'Ha ocurrido un error al registrar el usuario. Por favor, intenta nuevamente.'])->withInput($request->except('password', 'password_confirmation'));
    }
}


public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
}

}