<!DOCTYPE html>
    <html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Escritor - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-900 text-white hidden md:block">
            <div class="p-6 text-2xl font-bold border-b border-slate-800">
                Writer<span>Panel</span>
            </div>
            <nav class="mt-6">
                <a href="{{route('panel.writers')}}" class="flex items-center py-3 px-6 bg-blue-600 text-white">
                    <i class="fas fa-home mr-3"></i> Dashboard
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-file-alt mr-3"></i> Meus Artigos
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-user mr-3"></i> Perfil
                </a>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Bem-vindo, {{ $escritor->name }}</h2>
                
                <div class="flex items-center gap-4">
                    <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">
                        {{ ucfirst($escritor->role) }}
                    </span>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </button>
                    </form>
                </div>
            </header>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <div class="text-gray-400 text-sm font-medium uppercase">Artigos Publicados</div>
                        <div class="text-3xl font-bold text-gray-800">12</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <div class="text-gray-400 text-sm font-medium uppercase">Visualizações Totais</div>
                        <div class="text-3xl font-bold text-gray-800">1.420</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <div class="text-gray-400 text-sm font-medium uppercase">Status da Conta</div>
                        <div class="text-3xl font-bold text-blue-600">Ativa</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold">Informações do Perfil</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nome Completo</label>
                                <p class="text-gray-900 font-medium">{{ $escritor->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">E-mail de Acesso</label>
                                <p class="text-gray-900 font-medium">{{ $escritor->email }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500">Biografia</label>
                                <p class="text-gray-700 italic">"{{ $escritor->bio ?? 'Nenhuma bio cadastrada.' }}"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>