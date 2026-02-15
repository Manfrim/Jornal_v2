@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero-photo relative overflow-hidden group">
  <img src="img/capa_manfrim3.png" alt="Autor do jornal" 
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
<section class="bg-slate-50 py-20 border-t border-gray-100">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-slate-900 rounded-[3rem] p-10 md:p-16 shadow-2xl relative overflow-hidden group">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all duration-1000"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="mb-8">
                    <i class="fas fa-quote-left text-4xl text-blue-500 opacity-40"></i>
                </div>
                
                <div id="pensamento-container" class="flex flex-col items-center justify-center min-h-[140px] w-full text-center px-4">
                    <p id="texto-pensamento" class="text-xl md:text-3xl font-serif italic text-slate-100 leading-relaxed drop-shadow-md">
                        <span class="opacity-20 animate-pulse font-sans text-lg tracking-widest">Aguardando inspiração...</span>
                    </p>
                    <p id="autor-pensamento" class="mt-8 text-xs font-black uppercase tracking-[0.5em] text-blue-400 opacity-0 transition-opacity duration-1000 italic">
                    </p>
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
// --- LÓGICA DO PENSAMENTO ---
async function buscarNovoPensamento() {
    const textoEl = document.getElementById('texto-pensamento');
    const autorEl = document.getElementById('autor-pensamento');
    const icon = document.getElementById('btn-refresh-icon');

    if (icon) icon.classList.add('animate-spin');
    
    try {
        const response = await fetch("https://raw.githubusercontent.com/devmatheusguerra/frasesJSON/master/frases.json");
        const data = await response.json();
        const sorteada = data[Math.floor(Math.random() * data.length)];
        exibirComEfeito(sorteada.frase, sorteada.autor);
    } catch (err) {
        textoEl.innerText = "A sabedoria consiste em saber que nada se sabe.";
        autorEl.innerText = "— Sócrates";
        autorEl.classList.remove('opacity-0');
    } finally {
        if (icon) icon.classList.remove('animate-spin');
    }
}

function exibirComEfeito(texto, autor) {
    const textoEl = document.getElementById('texto-pensamento');
    const autorEl = document.getElementById('autor-pensamento');
    if (!textoEl || !autorEl) return;

    autorEl.classList.add('opacity-0');
    textoEl.innerText = "";
    let i = 0;
    
    function digitar() {
        if (i < texto.length) {
            textoEl.innerHTML += texto.charAt(i);
            i++;
            setTimeout(digitar, 30);
        } else {
            autorEl.innerText = `— ${autor}`;
            autorEl.classList.replace('opacity-0', 'opacity-100');
        }
    }
    digitar();
}

// --- LÓGICA DAS MATÉRIAS ---
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
                // Criamos a URL de forma segura. 
                // Se você usa slugs, o caminho abaixo é o padrão:
                const urlMateria = `{{ url('/materia') }}/${m.slug}`;

                return `
                <article class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 flex flex-col opacity-0 animate-fade-in-up" 
                         style="animation-delay: ${index * 150}ms; animation-fill-mode: forwards;">
                    
                    <a href="${urlMateria}" class="overflow-hidden relative group block">
                        <img src="${m.capa ? '/storage/' + m.capa : 'https://via.placeholder.com/600x400'}" 
                             class="w-full h-60 object-cover transition-transform duration-700 group-hover:scale-110" 
                             alt="${m.titulo}">
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                    </a>
                    
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-blue-600">${m.categoria || 'Artigo'}</span>
                        </div>
                        
                        <a href="${urlMateria}" class="group">
                            <h3 class="text-2xl font-serif font-bold mb-4 text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                                ${m.titulo}
                            </h3>
                        </a>

                        <p class="text-gray-600 text-sm mb-6 line-clamp-3 leading-relaxed font-light">
                            ${m.conteudo ? m.conteudo.replace(/<[^>]*>?/gm, '').substring(0, 140) + '...' : 'Confira a íntegra deste pensamento...'}
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
    // Inicia o pensamento um pouco depois das matérias para não sobrecarregar
    setTimeout(buscarNovoPensamento, 1500);
});
</script>

<style>
    /* Animações Customizadas via CSS (integradas com Tailwind) */
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