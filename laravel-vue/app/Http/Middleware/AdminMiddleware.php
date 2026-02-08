<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se está logado
        if (! auth()->check()) {
            return redirect('/login');
        }

        // Verifica se é admin (is_admin = 1)
        if (auth()->user()->is_admin != 1) {
            abort(403, 'Acesso negado. Apenas administradores podem acessar.');
        }

        return $next($request);
    }
}
