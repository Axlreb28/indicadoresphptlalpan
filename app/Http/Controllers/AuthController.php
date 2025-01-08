<?php 
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validación de datos de entrada
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');
        
        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            // Usar middleware para redirigir según el rol
            return redirect()->route('role.redirect');
        }

        // Si la autenticación falla, vuelve al formulario con un mensaje de error
        return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validación de datos de entrada
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'department' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|confirmed',
        ]);

        // Crear nuevo usuario
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->department = $request->department;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        // Asignar rol basado en el departamento
        if ($request->department == 'Dirección de Atención a Grupos Prioritarios') {
            $user->assignRole('direccion_grupos_prioritarios');
        }
        // Añadir lógica para otros departamentos según sea necesario

        // Redirigir al login después de un registro exitoso
        return redirect()->route('login')->with('status', 'Registration successful, please log in.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
