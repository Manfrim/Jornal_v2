<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Escritor - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-900 text-white hidden md:block shadow-2xl">
            <div class="p-6 text-2xl font-serif font-bold border-b border-slate-800 tracking-tight">
                Writer<span class="text-blue-500">Panel</span>
            </div>
            <nav class="mt-6">
                <a href="{{ route('panel.writers') }}" class="flex items-center py-3 px-6 bg-blue-600/10 text-blue-400 border-l-4 border-blue-600">
                    <i class="fas fa-chart-line mr-3"></i> Dashboard
                </a>
                <a href="{{ route('panel.articles') }}" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition group">
                    <i class="fas fa-file-alt mr-3 group-hover:text-blue-400"></i> Meus Artigos
                </a>
                <a href="{{ route('panel.perfil') }}" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition group">
                    <i class="fas fa-user-circle mr-3 group-hover:text-blue-400"></i> Perfil
                </a>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center border-b border-gray-100">
                <div>
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Visão Geral</h2>
                    <p class="text-xl font-bold text-gray-800">Bem-vindo, {{ $escritor->name }}</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <span class="text-xs bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full font-black uppercase tracking-tighter border border-blue-100">
                        {{ ucfirst($escritor->role) }}
                    </span>
                    
                    <form action="{{ route('logout') }}" method="POST" class="border-l pl-6">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors flex items-center gap-2 font-medium">
                            <i class="fas fa-power-off"></i> <span class="text-sm">Sair</span>
                        </button>
                    </form>
                </div>
            </header>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:border-blue-500 transition-all">
                        <div>
                            <div class="text-gray-400 text-xs font-black uppercase tracking-widest mb-1">Artigos Publicados</div>
                            <div class="text-4xl font-serif font-bold text-slate-800">{{ $totalArtigos }}</div>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:border-blue-500 transition-all">
                        <div>
                            <div class="text-gray-400 text-xs font-black uppercase tracking-widest mb-1">Visualizações Totais</div>
                            <div class="text-4xl font-serif font-bold text-slate-800">{{ number_format($totalViews, 0, ',', '.') }}</div>
                        </div>
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-green-600 group-hover:text-white transition-all">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group">
                        <div>
                            <div class="text-gray-400 text-xs font-black uppercase tracking-widest mb-1">Status da Conta</div>
                            <div class="text-4xl font-serif font-bold text-blue-600">Ativa</div>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                            <i class="fas fa-id-card text-blue-600"></i> Informações do Perfil
                        </h3>
                        <a href="{{ route('panel.perfil') }}" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-widest">Editar Perfil</a>
                    </div>
                    <div class="p-8 bg-slate-50/50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Nome Completo</label>
                                <p class="text-slate-900 font-serif text-lg font-medium">{{ $escritor->name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">E-mail de Acesso</label>
                                <p class="text-slate-900 font-medium">{{ $escritor->email }}</p>
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Sua Biografia</label>
                                <div class="bg-white p-6 rounded-2xl border border-gray-100 italic text-slate-600 leading-relaxed shadow-sm">
                                    "{{ $escritor->bio ?? 'Nenhuma bio cadastrada ainda. Conte um pouco sobre sua trajetória profissional.' }}"
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>