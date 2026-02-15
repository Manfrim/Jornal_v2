<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia; // <--- ESTA LINHA É A SOLUÇÃO DO SEU ERRO

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        // Agora o PHP sabe que Materia se refere ao arquivo em App\Models
        $query = Materia::where('status', 'publicado')->latest();

        // Filtro de busca simples (usando filled para evitar buscas vazias)
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        // Paginação de 12 em 12
        $materias = $query->paginate(12);

        // Retorna a view (certifique-se que o arquivo está em resources/views/pages/materias.blade.php)
        return view('pages.materias', compact('materias'));
    }
    public function show($slug)
    {
        // Busca a matéria pelo slug ou retorna erro 404 se não existir
        $materia = Materia::where('slug', $slug)
                        ->where('status', 'publicado')
                        ->firstOrFail();

        // Incrementa a coluna 'views' em +1
        $materia->increment('views');

        return view('pages.materia_interna', compact('materia'));
    }
}