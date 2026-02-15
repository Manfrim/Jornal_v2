@extends('layouts.app')

@section('title', 'Sobre o Autor | Prof. Manfrim')

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
                    <span class="text-blue-400 font-black uppercase tracking-[0.3em] text-xs mb-4">A voz por trás do jornal</span>
                    <h1 class="text-5xl md:text-7xl font-serif font-bold mb-8 leading-tight">Luiz Rogério <br class="hidden md:block"> Manfrim</h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <span class="bg-slate-800/50 px-5 py-2 rounded-full text-[11px] font-bold uppercase tracking-widest border border-slate-700 backdrop-blur-sm">Mestre em Gestão</span>
                        <span class="bg-slate-800/50 px-5 py-2 rounded-full text-[11px] font-bold uppercase tracking-widest border border-slate-700 backdrop-blur-sm">Consultor</span>
                        <span class="bg-slate-800/50 px-5 py-2 rounded-full text-[11px] font-bold uppercase tracking-widest border border-slate-700 backdrop-blur-sm">Business Designer</span>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-20">
        <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-16">
            
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-serif font-bold mb-8 flex items-center gap-4 text-slate-900">
                    Trajetória Profissional
                    <div class="h-px bg-slate-200 flex-1"></div>
                </h2>
                
                <div class="prose prose-slate prose-lg max-w-none font-serif text-slate-700 leading-relaxed">
                    <p class="mb-6">
                        Mestre em Gestão Estratégica, MBA em Marketing, MBA em Gestão Estratégica de Inovação, Especialista em Gestão de Negócios e Bacharel em Administração. Certificação em Business Design e Expert em Canvas (CEC).
                    </p>
                    <p class="mb-6 font-bold italic text-slate-900 border-l-4 border-blue-600 pl-6 py-2">
                        Consultor pertinente, Professor apaixonado, Palestrante provocativo, Inovador resiliente e Intraempreendedor maker. Fanático, obcecado e compulsivo pelo mundo da inovação.
                    </p>
                    <p class="mb-6">
                        Avaliador de Pitches e Mentor em programas de aceleração de startups no Cocreation Lab, IF Boost/Group, Sebrae, ENAP e Startup Farm. Colaborador nos livros “Educação Empreendedora no Distrito Federal” e “O futuro é das CHICS”.
                    </p>
                    <p class="mb-6">
                        Business Design no Banco do Brasil e pesquisador associado do Instituto Brasileiro de Cidades Humanas, Inteligentes, Criativas e Sustentáveis (IBRACHICS).
                    </p>
                    
                    <h3 class="text-xl font-bold font-sans uppercase tracking-widest mt-12 mb-6 text-slate-900 text-sm">Ecossistemas e Experiências</h3>
                    <p class="text-base font-sans text-slate-600 bg-slate-50 p-6 rounded-2xl border border-slate-100 italic">
                        Jornal de Brasília (DF), Arena Consulting Brasil (DF), Universidade Cruzeiro do Sul (DF), Centro Universitário do Distrito Federal - UDF, Nova Didáttica (SP), IMESB (SP), CPFL, Nossa Caixa Nosso Banco (SP), Microlins (SP), Sebrae (DF) e Governo do Distrito Federal (DF).
                    </p>
                </div>
            </div>

            <div class="space-y-12">
                <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-bolt text-6xl"></i>
                    </div>
                    <h3 class="text-blue-400 font-black uppercase tracking-widest text-[10px] mb-8">Whatever / Stats</h3>
                    
                    <ul class="space-y-8">
                        <li class="flex items-start gap-4">
                            <span class="text-3xl font-serif font-bold text-blue-500">40</span>
                            <p class="text-[11px] uppercase tracking-wider leading-tight text-slate-300">Palestras: Negócios, Gestão, Inovação e Futurismo</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="text-3xl font-serif font-bold text-blue-500">20</span>
                            <p class="text-[11px] uppercase tracking-wider leading-tight text-slate-300">Produções de Conteúdo Técnico e Científico</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="text-3xl font-serif font-bold text-blue-500">128</span>
                            <p class="text-[11px] uppercase tracking-wider leading-tight text-slate-300">Orientações de TCC em Graduação e Pós</p>
                        </li>
                    </ul>
                </div>

                <div class="p-8 border-2 border-dashed border-slate-200 rounded-[2.5rem] text-center group hover:border-blue-500 transition-all hover:bg-blue-50/30">
                    <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mb-4">Documentação Profissional</p>
                    <a href="{{ asset('Curriculum_Vitae.pdf') }}" target="_blank" class="inline-flex flex-col items-center">
                        <i class="fa-solid fa-file-pdf text-6xl mb-4 text-slate-900 group-hover:text-blue-600 transition-colors"></i>
                        <span class="font-bold text-slate-900 uppercase text-[11px] tracking-[0.2em]">Download Full CV</span>
                    </a>
                </div>

                <div class="flex justify-center gap-4">
                    <a href="https://www.instagram.com/prof_manfrim/" target="_blank" class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-900 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <i class="fa-brands fa-instagram fa-xl"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/manfrim/" target="_blank" class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-900 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <i class="fa-brands fa-linkedin fa-xl"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>
</div>
@endsection