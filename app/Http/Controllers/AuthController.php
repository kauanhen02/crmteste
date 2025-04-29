<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if(request()->user()){
            return redirect()->intended('dashboard');
        }
        return view('login.login');
    }

    public function login(Request $request)
    {
        // Validação básica dos campos de email e senha
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['status'] = 1;

        // Tentativa de login com as credenciais fornecidas
        if (Auth::attempt($credentials)) {
            // Redireciona para a dashboard ou rota protegida se o login for bem-sucedido
            return redirect()->intended('dashboard');
        }

        // Retorna com uma mensagem de erro se a autenticação falhar
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não são válidas.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
