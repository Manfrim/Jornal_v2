<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Apenas carrega o HTML base
    public function index()
    {
        return view('pages.home');
    }

    // Retorna as matérias recentes em JSON
    public function getRecentes()
    {
        // Filtra apenas por 'publicado'. 
        // Dica: Se no banco estiver 'Publicado' (P maiúsculo), mude aqui também!
        $materias = Materia::where('status', 'publicado')
                        ->latest()
                        ->take(10)
                        ->get();

        return response()->json($materias);
    }

    // Retorna as populares (as mais lidas) em JSON
    public function getPopulares()
    {
        $populares = Materia::where('status', 'publicado')
                            ->orderBy('views', 'desc')
                            ->take(5)
                            ->get();

        return response()->json($populares);
    }
}
