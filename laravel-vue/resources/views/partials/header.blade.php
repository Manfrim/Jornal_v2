<div class="bg-slate-50 border-b border-slate-200 py-2 text-[10px] uppercase tracking-[0.15em] font-bold text-slate-500">
    <div class="container mx-auto px-4 flex justify-between align-items-center">
        <span>
            {{ date('d/m/Y') }}
        </span>
        <span class="hidden md:block">
            Jornal pessoal <span class="mx-2 text-slate-300">|</span> por Prof. Manfrim
        </span>
    </div>
</div>

<nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-slate-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">

            <a class="flex items-center gap-2 shrink-0" href="{{ route('home') }}">
                <img src="{{ asset('img/logotipo.png') }}"
                    alt="Logo Professor Manfrim"
                    class="h-12 w-auto object-contain transition-transform hover:scale-105">
            </a>

            <button id="mobile-menu-button" class="lg:hidden p-2 text-slate-600 hover:bg-slate-50 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <div class="hidden lg:flex items-center space-x-8 font-bold text-[11px] uppercase tracking-widest text-slate-600">
                <a href="/" class="hover:text-blue-600 transition-colors py-2 border-b-2 border-transparent hover:border-blue-600">Home</a>
                <a href="#" class="hover:text-blue-600 transition-colors py-2 border-b-2 border-transparent hover:border-blue-600">Artigos</a>
                <a href="#" class="hover:text-blue-600 transition-colors py-2 border-b-2 border-transparent hover:border-blue-600">Currículo</a>
                <a href="#" class="hover:text-blue-600 transition-colors py-2 border-b-2 border-transparent hover:border-blue-600">Portfólio</a>
            </div>

            <div class="hidden lg:flex items-center bg-slate-100 rounded-full px-4 py-1.5 border border-transparent focus-within:border-blue-300 focus-within:bg-white transition-all">
                <input type="search" placeholder="Pesquisar..." class="bg-transparent border-none outline-none text-xs w-32 focus:w-48 transition-all">
                <button class="text-slate-400 hover:text-blue-600">
                    <i class="fas fa-search text-xs"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden pb-6 pt-2 space-y-4 font-bold text-xs uppercase tracking-widest border-t border-slate-50">
            <a href="/" class="block text-slate-600 hover:text-blue-600 py-2">Home</a>
            <a href="#" class="block text-slate-600 hover:text-blue-600 py-2">Artigos</a>
            <a href="#" class="block text-slate-600 hover:text-blue-600 py-2">Currículo</a>
            <a href="#" class="block text-slate-600 hover:text-blue-600 py-2">Portfólio</a>
            
            <form class="flex gap-2 pt-4">
                <input type="search" placeholder="Pesquisar" class="w-full bg-slate-100 border-none rounded-full px-4 py-2 text-xs">
                <button class="bg-slate-900 text-white px-4 py-2 rounded-full text-[10px]">OK</button>
            </form>
        </div>
    </div>
</nav>

<script>
    // Lógica simples para o Menu Mobile
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>