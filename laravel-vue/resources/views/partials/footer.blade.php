<footer class="bg-slate-900 text-white border-t border-slate-800">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
            
            <div class="text-center md:text-left">
                <h3 class="font-serif text-2xl font-bold tracking-tight">
                    Prof. <span class="text-blue-500">Manfrim</span>
                </h3>
                <p class="text-slate-400 text-xs uppercase tracking-[0.2em] mt-2">
                    Inovação & Gestão Estratégica
                </p>
            </div>

            <div class="flex justify-center gap-8 text-sm font-bold uppercase tracking-widest">
                <a href="{{ url('/') }}" class="hover:text-blue-500 transition-colors">Home</a>
                <a href="{{ route('portfolio') }}" class="hover:text-blue-500 transition-colors">Portfólio</a>
                <a href="{{ route('curriculo') }}" class="hover:text-blue-500 transition-colors">Currículo</a>
            </div>

            <div class="flex justify-center md:justify-end gap-5">
                <a href="https://www.instagram.com/prof_manfrim/" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition-all">
                    <i class="fa-brands fa-instagram text-lg"></i>
                </a>
                <a href="https://www.linkedin.com/in/manfrim/" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition-all">
                    <i class="fa-brands fa-linkedin-in text-lg"></i>
                </a>
            </div>

        </div>

        <hr class="border-slate-800 my-10">

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-[10px] uppercase tracking-[0.2em]">
            <p>© {{ date('Y') }} Luiz Rogério Manfrim. Todos os direitos reservados.</p>
            <p class="flex items-center gap-2">
                Desenvolvido com <i class="fa-solid fa-heart text-red-500 animate-pulse"></i> para o futuro.
            </p>
        </div>
    </div>
</footer>