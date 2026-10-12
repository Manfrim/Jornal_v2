@php
    use Illuminate\Support\Facades\Storage;
@endphp
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
                <a href="{{ route('panel.companies.index') }}" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition group">
                    <i class="fas fa-building mr-3 group-hover:text-blue-400"></i> Logos Empresas
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
                        {{ ucfirst($escritor->role ?? 'Escritor') }}
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
                <!-- Alertas de Feedback -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Métrica Cards -->
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

                <!-- Formulário de Nova Logo -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-10">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                            <i class="fas fa-upload text-blue-600"></i> Cadastrar Logo de Empresa
                        </h3>
                    </div>
                    <form action="{{ route('panel.companies.store') }}" method="POST" enctype="multipart/form-data" class="p-8 bg-slate-50/50">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Nome da Empresa</label>
                                <input type="text" name="name" required placeholder="Ex: Empresa X" 
                                    class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 transition">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Arquivo da Logo (SVG, PNG, WEBP)</label>
                                <input type="file" name="logo" accept="image/*" required 
                                    class="w-full bg-white border border-gray-200 rounded-xl px-3 py-1.5 text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Ordem de Exibição</label>
                                <input type="number" name="order" value="0" 
                                    class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 transition">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-between items-center">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                                <span class="text-xs font-bold text-slate-700">Exibir imediatamente no carrossel</span>
                            </label>

                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                                <i class="fas fa-plus"></i> Salvar Logo
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabela de Logos Cadastradas -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-10">
                    <div class="p-8 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                            <i class="fas fa-list text-blue-600"></i> Logos Ativas no Carrossel
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-gray-100">
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Logo</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Empresa</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Cadastrado por</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Ordem</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($companies ?? [] as $company)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="p-4">
                                            <div class="w-16 h-10 bg-gray-100 rounded-lg p-1 flex items-center justify-center border border-gray-200">
                                                <img src="{{ asset('storage/' . $company->logo_path) }}" 
                                                     alt="{{ $company->name }}" 
                                                     class="max-h-full max-w-full object-contain">
                                            </div>
                                        </td>
                                        <td class="p-4 font-bold text-slate-800 text-sm">{{ $company->name }}</td>
                                        <td class="p-4 text-xs text-gray-500 font-medium">
                                            <i class="fas fa-user-edit mr-1 text-gray-400"></i>
                                            {{ $company->writer->name ?? 'Desconhecido' }}
                                        </td>
                                        <td class="p-4 text-xs font-bold text-slate-600">{{ $company->order }}</td>
                                        <td class="p-4 text-right">
                                            <form action="{{ route('panel.companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta logo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition p-2">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-gray-400 text-sm">
                                            Nenhuma logo cadastrada ainda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Seção Perfil -->
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