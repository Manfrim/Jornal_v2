<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Processa o login
     */
    public function login(Request $request)
    {
        // 1. Validar dados
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Tentar autenticar
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email ou senha inválidos'])
                ->withInput();
        }

        // 3. Regenerar sessão (segurança)
        $request->session()->regenerate();

        // 4. Redirecionar conforme perfil
        // Redireciona conforme tipo de usuário
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard'); // Admin → dashboard admin
        }

        return redirect()->route('user.dashboard'); // Usuário comum → dashboard user

            return redirect()->route('home');
        }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
