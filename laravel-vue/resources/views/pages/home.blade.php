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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('grid-recentes');

    fetch("{{ url('/api/materias/recentes') }}")
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                container.innerHTML = '<p class="col-span-full text-center text-gray-400">Nenhuma matéria encontrada no banco de dados.</p>';
                return;
            }

            container.innerHTML = data.map((m, index) => `
                <article class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 flex flex-col opacity-0 animate-fade-in-up" 
                         style="animation-delay: ${index * 150}ms; animation-fill-mode: forwards;">
                    <div class="overflow-hidden">
                        <img src="${m.capa ? '/storage/' + m.capa : 'https://via.placeholder.com/400x250'}" 
                             class="w-full h-48 object-cover transition-transform duration-500 hover:scale-110" 
                             alt="${m.titulo}">
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold mb-3 text-gray-900 leading-tight">${m.titulo}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            ${m.conteudo ? m.conteudo.replace(/<[^>]*>?/gm, '').substring(0, 120) : 'Sem descrição...'}
                        </p>
                        <div class="mt-auto">
                            <a href="/materia/${m.slug}" 
                               class="group relative inline-flex items-center justify-center px-6 py-2 font-bold text-white transition-all duration-300 bg-black rounded-lg hover:bg-gray-800 hover:pr-10">
                                <span>Ler mais</span>
                                <i class="fas fa-arrow-right absolute right-4 opacity-0 transition-all duration-300 group-hover:opacity-100"></i>
                            </a>
                        </div>
                    </div>
                </article>
            `).join('');
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = '<p class="col-span-full text-center text-red-500">Erro ao carregar matérias.</p>';
        });
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