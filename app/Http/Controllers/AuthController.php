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
        // Cambiamos email por username para que coincida con tu SQL
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Buscamos por la columna 'username' que es la que tienes en Workbench
        $user = User::where('username', $request->username)
            ->where('password', md5($request->password))
            ->first();

        if ($user) {
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
