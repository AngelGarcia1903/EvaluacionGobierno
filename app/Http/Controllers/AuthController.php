<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Usamos MD5 por requerimiento del examen
        $user = User::where('username', $request->username)
            ->where('password', md5($request->password))
            ->first();

        if ($user) {
            // Iniciamos sesión manual
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->username); // Usamos username para consistencia

            // Regenerar sesión es una buena práctica de seguridad (opcional pero suma puntos)
            $request->session()->regenerate();

            return redirect()->route('dashboard'); // Nombre de ruta estándar
        }

        return back()->withErrors(['login_error' => 'Usuario o contraseña incorrectos.']);
    }
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
