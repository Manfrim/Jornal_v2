@extends('layouts.app')

@section('title', 'Arquivo de Matérias')

@section('content')
<header class="bg-slate-900 py-16 text-white">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-serif font-bold mb-6 animate-fade-in">Arquivo do Jornal</h1>
        <p class="text-slate-400 max-w-2xl mx-auto mb-10 italic">Explore a coleção completa de pensamentos e análises do Prof. Manfrim.</p>
        
        <form action="{{ route('materias.index') }}" method="GET" class="max-w-lg mx-auto relative group">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Pesquisar no arquivo..." 
                   class="w-full bg-slate-800 border border-slate-700 text-white rounded-full py-4 px-8 outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            <button type="submit" class="absolute right-3 top-2 bg-blue-600 hover:bg-blue-500 p-2 px-6 rounded-full transition-colors">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</header>

<div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($materias as $m)
            <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col border border-gray-100 group">
                <div class="overflow-hidden rounded-t-2xl h-48">
                    <img src="{{ $m->capa ? asset('storage/' . $m->capa) : 'https://via.placeholder.com/600x400' }}" 
                         alt="{{ $m->titulo }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 mb-2">
                        {{ $m->categoria ?? 'Artigo' }}
                    </span>
                    <h2 class="text-xl font-serif font-bold text-gray-900 mb-3 leading-tight group-hover:text-blue-700 transition-colors">
                        {{ $m->titulo }}
                    </h2>
                    <p class="text-gray-500 text-sm line-clamp-3 mb-6">
                        {{ Str::limit(strip_tags($m->conteudo), 100) }}
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center">
                        <span class="text-[10px] text-gray-400">{{ $m->created_at->format('d/m/Y') }}</span>
                        <a href="/materia/{{ $m->slug }}" class="text-xs font-bold uppercase tracking-tighter hover:text-blue-600">
                            Ler mais →
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-20">
                <i class="fas fa-search text-5xl text-gray-200 mb-4"></i>
                <p class="text-gray-400 font-serif italic text-xl">Nenhuma matéria encontrada com esse título.</p>
                <a href="{{ route('materias.index') }}" class="mt-4 inline-block text-blue-600 font-bold underline">Limpar busca</a>
            </div>
        @endforelse
    </div>

    <div class="mt-16 flex justify-center">
        {{ $materias->appends(request()->query())->links() }}
    </div>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .animate-fade-in { animation: fadeIn 1s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection