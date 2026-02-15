@extends('layouts.app')

@section('title', 'Portfólio | Prof. Manfrim')

@section('content')
<div class="bg-white">
    <header class="bg-slate-900 py-12 md:py-20 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16">
                
                <div class="flex justify-center items-center shrink-0 w-full md:w-auto">
                    <div class="relative group w-72 h-[380px] md:w-[420px] md:h-[580px] flex items-center justify-center">
                        <div class="absolute inset-0 bg-blue-600 rounded-[100%] blur-[60px] opacity-20 group-hover:opacity-40 transition duration-1000 scale-90"></div>
                        <img src="{{ asset('img/imagem_autor.jpg') }}" 
                             alt="Luiz Rogério Manfrim" 
                             class="relative w-full h-full object-contain z-10 filter drop-shadow-2xl">
                    </div>
                </div>

                <div class="text-center md:text-left flex flex-col items-center md:items-start">
                    <span class="text-blue-400 font-black uppercase tracking-[0.3em] text-[10px] mb-4">Manifesto Profissional</span>
                    <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight text-white italic">Luiz R. <br> Manfrim</h1>
                    <div class="h-1 w-20 bg-blue-600 mb-8"></div>
                    <p class="text-slate-400 text-lg font-serif italic max-w-sm">
                        "Transformando conhecimento em inovação e resultados tangíveis."
                    </p>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-20">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-xs uppercase font-black tracking-[0.5em] text-blue-600 mb-4">O que me move</h2>
                <h3 class="text-4xl font-serif font-bold text-slate-900 italic">Propósito</h3>
            </div>

            <div class="space-y-4">
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:border-blue-200 transition-colors group">
                    <p class="text-2xl md:text-3xl font-serif text-slate-700 leading-snug group-hover:text-slate-900">
                        Cocriar <span class="text-blue-600 font-bold">experiências</span>, jornadas, ambientes, conhecimentos e aprendizagens,
                    </p>
                </div>

                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:border-blue-200 transition-colors group ml-0 md:ml-12">
                    <p class="text-2xl md:text-3xl font-serif text-slate-700 leading-snug group-hover:text-slate-900">
                        que conecte e engaje <span class="text-blue-600 font-bold">pessoas</span> e organizações,
                    </p>
                </div>

                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:border-blue-200 transition-colors group">
                    <p class="text-2xl md:text-3xl font-serif text-slate-700 leading-snug group-hover:text-slate-900">
                        na aplicação de técnicas, ferramentas, <span class="text-blue-600 font-bold">métodos</span> e abordagens,
                    </p>
                </div>

                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:border-blue-200 transition-colors group ml-0 md:ml-12 border-l-4 border-l-blue-600">
                    <p class="text-2xl md:text-3xl font-serif text-slate-900 leading-snug font-bold">
                        que estimule a inovação, supere desafios e melhore resultados.
                    </p>
                </div>
            </div>

            <div class="mt-20 flex flex-col items-center">
                <div class="p-10 border-2 border-dashed border-slate-200 rounded-[3rem] text-center w-full group hover:border-blue-500 transition-all hover:bg-blue-50/30">
                    <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mb-6">Documento Oficial</p>
                    <a href="{{ asset('Portfólio Contributivo - Prof_Manfrim v5.pdf') }}" target="_blank" class="inline-flex flex-col items-center">
                        <i class="fa-solid fa-file-pdf text-7xl mb-4 text-slate-900 group-hover:text-blue-600 transition-colors animate-pulse"></i>
                        <span class="font-bold text-slate-900 uppercase text-xs tracking-[0.3em]">Download Portfólio Contributivo</span>
                    </a>
                </div>

                <div class="flex gap-6 mt-12">
                    <a href="https://www.instagram.com/prof_manfrim/" target="_blank" class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-900 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <i class="fa-brands fa-instagram fa-2xl"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/manfrim/" target="_blank" class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-900 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <i class="fa-brands fa-linkedin fa-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection