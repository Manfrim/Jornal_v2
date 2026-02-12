<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Writer; 
class Writers extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // USANDO O GUARD 'escritor' QUE CRIAMOS NO CONFIG/AUTH.PHP
        if (Auth::guard('escritor')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('panel.writers'));
        }

        return back()->withErrors(['email' => 'Credenciais inválidas para escritor.']);
    }
    public function dashboard()
    {
        // 1. Pegamos os dados do escritor logado através do guard específico
        $escritor = Auth::guard('escritor')->user();

        // 2. Verificamos se ele realmente existe (segurança extra caso o middleware falhe)
        if (!$escritor) {
            return redirect()->route('login.escritores')->with('error', 'Acesso negado.');
        }

        // 3. Retornamos a view passando os dados do escritor
        // O primeiro parâmetro é o caminho do arquivo: resources/views/admin/writers/dashboard.blade.php
        return view('admin.writers.dashboard', [
            'escritor' => $escritor
        ]);
    }
    public function articles(){
            // Pegamos o escritor logado
        $escritor = Auth::guard('escritor')->user();

        // Carregamos as matérias relacionadas a ele usando o hasMany que criamos no Model
        $materias = $escritor->materias()->latest()->get();

        return view('admin.writers.dashboard_Artigos', compact('escritor', 'materias'));
    }
    public function uploadImageEditor(Request $request)
        {
            // O middleware já barrou quem não é escritor, 
            // mas aqui você garante que o arquivo é realmente uma imagem
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Máximo 5MB
            ]);

            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('uploads/editor', 'public');
                
                return response()->json([
                    'location' => asset('storage/' . $path)
                ]);
            }

            return response()->json(['error' => 'Upload falhou'], 400);
        }
}

