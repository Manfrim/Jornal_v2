<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWriter
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifica se o usuário está logado
        // 2. Verifica se o 'role' é um dos permitidos (admin, editor ou writer)
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'editor', 'writer'])) {
            return $next($request);
        }

        // Se não for escritor, redireciona ou dá erro 403
        abort(403, 'Acesso negado. Esta área é exclusiva para escritores.');
    }
}