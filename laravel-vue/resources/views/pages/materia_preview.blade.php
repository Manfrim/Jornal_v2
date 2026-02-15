@extends('layouts.app')

@section('title', $materia->titulo)

@section('content')

{{-- BANNER DE PREVIEW: Só aparece se a variável $previewMode existir --}}
@if(isset($previewMode) && $previewMode)
<div class="bg-slate-900 text-white border-b border-blue-500/30 sticky top-0 z-[9999] shadow-2xl">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-400">
                Visualização de Rascunho
            </span>
        </div>
        <button onclick="window.close()" class="text-[10px] font-bold bg-white/10 hover:bg-white/20 px-4 py-1.5 rounded transition-all uppercase tracking-widest border border-white/10">
            Voltar ao Painel
        </button>
    </div>
</div>
@endif

<article class="min-h-screen bg-white">
    <header class="container mx-auto px-4 pt-12 pb-8 max-w-4xl">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded">
                {{ $materia->categoria ?? 'Artigo' }}
            </span>
            <span class="text-gray-400 text-xs font-serif italic">
                @if($materia->status == 'rascunho')
                    Rascunho (Não Publicado)
                @else
                    Publicado em {{ $materia->created_at->format('d/m/Y') }}
                @endif
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-serif font-bold text-slate-900 leading-tight mb-8">
            {{ $materia->titulo }}
        </h1>

        @if($materia->capa)
        <div class="rounded-3xl overflow-hidden shadow-2xl mb-12">
            <img src="{{ asset('storage/' . $materia->capa) }}" alt="{{ $materia->titulo }}" class="w-full h-auto object-cover max-h-[500px]">
        </div>
        @endif
    </header>

    <div class="container mx-auto px-4 max-w-3xl pb-20">
        <div class="prose prose-slate prose-lg lg:prose-xl font-serif leading-relaxed text-slate-800">
            {!! $materia->conteudo !!}
        </div>

        <div class="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900">Prof. Manfrim</p>
                    <p class="text-xs text-slate-500">Autor e Educador</p>
                </div>
            </div>

            <a href="{{ route('materias.index') }}" class="text-blue-600 font-bold text-sm hover:underline">
                ← Voltar para o arquivo
            </a>
        </div>
    </div>
</article>

<style>
    .prose p { margin-bottom: 1.5rem; }
    .prose h2 { font-size: 1.8rem; font-weight: bold; margin-top: 2rem; margin-bottom: 1rem; font-family: serif; }
    .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.5rem; }
    .prose blockquote { border-left: 4px solid #3b82f6; padding-left: 1rem; font-style: italic; color: #475569; margin: 2rem 0; }
</style>
@endsection