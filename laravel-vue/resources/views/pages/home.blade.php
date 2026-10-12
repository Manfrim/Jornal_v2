@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero-photo relative overflow-hidden group">
  <img src="{{ asset('img/capa_manfrim3.png') }}" alt="Autor do jornal" 
       class="transition-transform duration-[10000ms] ease-out transform group-hover:scale-110" />
  
  <div class="hero-overlay flex flex-col items-center justify-center animate-fade-in-up">
    <h1 class="hover:tracking-widest transition-all duration-700 ease-in-out cursor-default">
      Prof Manfrim
    </h1>
    <p class="opacity-0 animate-fade-in delay-500">
      Um jornal escrito por uma só voz
    </p>
  </div>
</section>

<br>

<div class="container mx-auto px-4 py-12">
    <div class="overflow-hidden mb-8">
        <h2 class="text-3xl font-bold border-b-2 border-black inline-block transform -translate-x-full animate-slide-in-right pb-2">
            Últimas Publicações
        </h2>
    </div>
    
    <div id="grid-recentes" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="col-span-full text-center py-10">
            <p class="text-gray-500 animate-pulse flex items-center justify-center gap-2">
                <i class="fas fa-feather-alt animate-bounce"></i> 
                Buscando matérias do professor...
            </p>
        </div>
    </div>
</div>

<!-- CARROSSEL DE LOGOS DAS EMPRESAS -->
@if(isset($companies) && $companies->count() > 0)
<section class="py-12 bg-white border-y border-gray-100 overflow-hidden">
    <div class="container mx-auto px-4 mb-6 text-center">
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Parceiros & Empresas</p>
    </div>

    <!-- Container com efeito de fade nas bordas -->
    <div class="relative w-full flex overflow-x-hidden mask-gradient">
        <!-- Track que desliza infinitamente -->
        <div class="flex gap-12 items-center whitespace-nowrap animate-marquee">
            @foreach($companies as $company)
                <div class="flex-shrink-0 w-36 h-20 bg-slate-50 border border-gray-100 rounded-2xl p-4 flex items-center justify-center grayscale hover:grayscale-0 opacity-70 hover:opacity-100 transition-all duration-300">
                    <img src="{{ asset('storage/' . $company->logo_path) }}" 
                         alt="{{ $company->name }}" 
                         title="{{ $company->name }}"
                         class="max-h-full max-w-full object-contain">
                </div>
            @endforeach
        </div>

        <!-- Duplicação do loop para criar a ilusão de loop infinito sem quebras -->
        <div class="flex gap-12 items-center whitespace-nowrap animate-marquee" aria-hidden="true">
            @foreach($companies as $company)
                <div class="flex-shrink-0 w-36 h-20 bg-slate-50 border border-gray-100 rounded-2xl p-4 flex items-center justify-center grayscale hover:grayscale-0 opacity-70 hover:opacity-100 transition-all duration-300">
                    <img src="{{ asset('storage/' . $company->logo_path) }}" 
                         alt="{{ $company->name }}" 
                         title="{{ $company->name }}"
                         class="max-h-full max-w-full object-contain">
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-slate-50 py-20 border-t border-gray-100">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-slate-900 rounded-[3rem] p-10 md:p-16 shadow-2xl relative overflow-hidden group">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-1000"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="mb-8">
                    <i class="fas fa-quote-left text-4xl text-blue-500 opacity-40"></i>
                </div>
                
                <div id="pensamento-container" class="flex flex-col items-center justify-center min-h-[140px] w-full text-center px-4">
                    <p id="texto-pensamento" class="text-xl md:text-3xl font-serif italic text-slate-100 leading-relaxed drop-shadow-md min-h-[3rem] whitespace-pre-wrap"></p>
                    <p id="autor-pensamento" class="mt-8 text-xs font-black uppercase tracking-[0.5em] text-blue-400 opacity-0 transition-opacity duration-1000 italic min-h-[1.5rem]"></p>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-800 w-full flex justify-center">
                    <button onclick="buscarNovoPensamento()" 
                            class="group flex items-center gap-3 text-slate-500 hover:text-white transition-all text-[10px] uppercase font-bold tracking-[0.2em]">
                        <i class="fas fa-sync-alt group-hover:rotate-180 transition-transform duration-700 text-blue-500" id="btn-refresh-icon"></i>
                        <span>Refletir novamente</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// --- LÓGICA DO PENSAMENTO (PREVENÇÃO DE ENCAVALAMENTO E FORMATAÇÃO DE ESPAÇOS) ---
let currentExecutionId = 0;

async function buscarNovoPensamento() {
    currentExecutionId++;
    const myExecutionId = currentExecutionId;

    const textoEl = document.getElementById('texto-pensamento');
    const autorEl = document.getElementById('autor-pensamento');
    const icon = document.getElementById('btn-refresh-icon');

    if (icon) icon.classList.add('animate-spin');

    // Limpa os campos usando textContent
    if (textoEl) textoEl.textContent = "Aguardando inspiração...";
    if (autorEl) {
        autorEl.classList.add('opacity-0');
        autorEl.textContent = "";
    }

    try {
        const response = await fetch("https://raw.githubusercontent.com/devmatheusguerra/frasesJSON/master/frases.json");
        const data = await response.json();
        
        if (myExecutionId !== currentExecutionId) return;

        const sorteada = data[Math.floor(Math.random() * data.length)];
        exibirComEfeito(sorteada.frase, sorteada.autor, myExecutionId);
    } catch (err) {
        if (myExecutionId !== currentExecutionId) return;
        exibirComEfeito("A sabedoria consiste em saber que nada se sabe.", "Sócrates", myExecutionId);
    } finally {
        if (icon) icon.classList.remove('animate-spin');
    }
}

function exibirComEfeito(texto, autor, executionId) {
    const textoEl = document.getElementById('texto-pensamento');
    const autorEl = document.getElementById('autor-pensamento');
    if (!textoEl || !autorEl) return;

    // Normaliza quebras de linha e múltiplos espaços do JSON para espaços únicos
    const textoFormatado = texto.replace(/\s+/g, ' ').trim();

    textoEl.textContent = "";
    let i = 0;

    function digitar() {
        if (executionId !== currentExecutionId) return;

        if (i < textoFormatado.length) {
            textoEl.textContent += textoFormatado.charAt(i);
            i++;
            setTimeout(digitar, 30);
        } else {
            autorEl.textContent = `— ${autor}`;
            autorEl.classList.remove('opacity-0');
            autorEl.classList.add('opacity-100');
        }
    }

    digitar();
}

// --- LÓGICA DAS MATÉRIAS ---
const PLACEHOLDER = "data:image/svg+xml;utf8," + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400"><rect width="100%" height="100%" fill="#e2e8f0"/></svg>');
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

function carregarMaterias() {
    const container = document.getElementById('grid-recentes');

    fetch("{{ url('/api/materias/recentes') }}")
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                container.innerHTML = '<p class="col-span-full text-center text-gray-400 font-serif italic py-10">O professor ainda está preparando os próximos textos...</p>';
                return;
            }

            container.innerHTML = data.map((m, index) => {
                const urlMateria = `{{ url('/materia') }}/${encodeURIComponent(m.slug)}`;

                return `
                <article class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 flex flex-col opacity-0 animate-fade-in-up" 
                         style="animation-delay: ${index * 150}ms; animation-fill-mode: forwards;">
                    
                    <a href="${urlMateria}" class="overflow-hidden relative group block">
                        <img src="${m.capa ? '/storage/' + m.capa : PLACEHOLDER}" 
                             class="w-full h-60 object-cover transition-transform duration-700 group-hover:scale-110" 
                             alt="${esc(m.titulo)}">
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                    </a>
                    
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-blue-600">${esc(m.categoria || 'Artigo')}</span>
                        </div>
                        
                        <a href="${urlMateria}" class="group">
                            <h3 class="text-2xl font-serif font-bold mb-4 text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                                ${esc(m.titulo)}
                            </h3>
                        </a>

                        <p class="text-gray-600 text-sm mb-6 line-clamp-3 leading-relaxed font-light">
                            ${m.resumo ? esc(m.resumo) : 'Confira a íntegra deste pensamento...'}
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-gray-50">
                            <a href="${urlMateria}" 
                               class="group flex items-center justify-between font-black text-[11px] uppercase tracking-widest text-black hover:text-blue-600 transition-colors">
                                <span>Ler Análise Completa</span>
                                <i class="fas fa-arrow-right transform transition-transform group-hover:translate-x-2"></i>
                            </a>
                        </div>
                    </div>
                </article>
            `}).join('');
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = '<p class="col-span-full text-center text-red-500 font-serif">Erro ao carregar o feed. Por favor, recarregue a página.</p>';
        });
}

// INICIALIZAÇÃO
window.addEventListener('load', () => {
    carregarMaterias();
    setTimeout(buscarNovoPensamento, 1000);
});
</script>

<style>
    #texto-pensamento {
        white-space: pre-wrap;
    }

    /* Animação Marquee do Carrossel de Logos */
    @keyframes marquee {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-100%); }
    }

    .animate-marquee {
        display: flex;
        animation: marquee 25s linear infinite;
    }

    .animate-marquee:hover {
        animation-play-state: paused;
    }

    /* Suavização lateral do carrossel */
    .mask-gradient {
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }

    /* Animações Customizadas via CSS */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInRight {
        from { transform: translateX(-100%); }
        to { transform: translateX(0); }
    }

    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
    .animate-fade-in { animation: fadeIn 1.2s ease-in forwards; }
    .animate-slide-in-right { animation: slideInRight 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards; }
    .delay-500 { animation-delay: 500ms; }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection