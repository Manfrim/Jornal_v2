<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Importante adicionar esta linha

class CheckWriter
{
    public function handle(Request $request, Closure $next): Response
    {
        // Tentamos pegar o usuário do guard 'escritor' (sua nova tabela)
        // Se não houver ninguém, tentamos o guard padrão 'web'
        $user = Auth::guard('escritor')->user() ?? Auth::user();

        // 1. Verifica se existe algum usuário logado
        // 2. Verifica se o 'role' desse usuário permite acesso
        if ($user && in_array($user->role, ['admin', 'editor', 'writer'])) {
            return $next($request);
        }

        // Se não houver usuário ou o role for inválido
        abort(403, 'Acesso negado. Esta área é exclusiva para a equipe de escritores.');
    }
}