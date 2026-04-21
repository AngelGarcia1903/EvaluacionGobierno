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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Buscamos al usuario por email y comparamos el hash MD5
        $user = User::where('email', $request->email)
            ->where('password', md5($request->password)) // Requisito del examen
            ->first();

        if ($user) {
            // Manejo de sesiones manual para cumplir con el punto
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['login_error' => 'Credenciales incorrectas']);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
