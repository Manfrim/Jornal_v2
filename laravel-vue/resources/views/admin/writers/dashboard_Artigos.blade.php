<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Artigos - {{ config('app.name') }}</title>
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
                <a href="{{ route('panel.writers') }}" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-home mr-3"></i> Dashboard
                </a>
                <a href="#" class="flex items-center py-3 px-6 bg-blue-600 text-white">
                    <i class="fas fa-file-alt mr-3"></i> Meus Artigos
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-user mr-3"></i> Perfil
                </a>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Gerenciar Artigos</h2>
                
                <div class="flex items-center gap-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-600 transition">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </button>
                    </form>
                </div>
            </header>

            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Minhas Matérias</h3>
                        <p class="text-gray-500 text-sm">Você possui {{ $materias->count() }} artigos cadastrados.</p>
                    </div>
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold flex items-center transition shadow-md">
                        <i class="fas fa-plus mr-2"></i> Novo Artigo
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600">Título</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600">Categoria</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600">Data</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($materias as $materia)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-800 font-medium">{{ $materia->titulo }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    <span class="text-xs bg-gray-200 px-2 py-1 rounded">{{ $materia->categoria ?? 'Geral' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($materia->status == 'publicado')
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold">Publicado</span>
                                    @else
                                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-bold">Rascunho</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">
                                    {{ $materia->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" title="Editar"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="text-red-500 hover:text-red-700" title="Excluir"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    <i class="fas fa-folder-open text-4xl mb-3 block"></i>
                                    Nenhum artigo encontrado. Comece a escrever agora!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>