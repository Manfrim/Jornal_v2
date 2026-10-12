<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    // Carrega a página inicial enviando as logos para o carrossel na View Blade
    public function index()
    {
        $companies = Company::where('is_active', true)
                            ->orderBy('order', 'asc')
                            ->get();

        return view('pages.home', compact('companies'));
    }

    // Retorna as matérias recentes em JSON
    public function getRecentes()
    {
        $materias = Materia::where('status', 'publicado')
                        ->latest()
                        ->take(10)
                        ->get();

        return response()->json($materias->map(fn ($m) => $this->resumo($m)));
    }

    // Retorna as populares (as mais lidas) em JSON
    public function getPopulares()
    {
        $populares = Materia::where('status', 'publicado')
                            ->orderBy('views', 'desc')
                            ->take(5)
                            ->get();

        return response()->json($populares->map(fn ($m) => $this->resumo($m)));
    }

    // Envia só um resumo em vez do conteúdo completo da matéria
    private function resumo(Materia $m): array
    {
        return [
            'id'         => $m->id,
            'titulo'     => $m->titulo,
            'slug'       => $m->slug,
            'capa'       => $m->capa,
            'categoria'  => $m->categoria,
            'views'      => $m->views,
            'created_at' => $m->created_at,
            'resumo'     => Str::limit(trim(html_entity_decode(strip_tags($m->conteudo))), 140),
        ];
    }

    // Retorna as logos ativas em JSON (caso vá renderizar o carrossel via JS/fetch)
    public function getLogos()
    {
        $companies = Company::where('is_active', true)
                            ->orderBy('order', 'asc')
                            ->get(['id', 'name', 'logo_path', 'order']);

        return response()->json($companies);
    }
}