<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="min-h-screen bg-gray-100 flex flex-col font-sans text-gray-900">

    <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Painel Admin</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                Sair
            </button>
        </form>
    </header>

    <main class="flex-1 p-6 space-y-8">
        
        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h2 class="text-xl font-semibold mb-2">Bem-vindo, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-600">
                Status: <span class="font-bold text-blue-600">{{ auth()->user()->is_admin ? 'Administrador' : 'Usuário' }}</span>
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-blue-700">Escritores</h3>
                    <p class="text-3xl font-bold mt-1 text-blue-900">
                        {{ $writers->count() }}
                    </p>
                </div>
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-700">Posts</h3>
                    <p class="text-3xl font-bold mt-1 text-green-900">128</p>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                    <h3 class="font-semibold text-yellow-700">Comentários</h3>
                    <p class="text-3xl font-bold mt-1 text-yellow-900">512</p>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-sm p-6 border border-gray-200" x-data="{ open: false }">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h2 class="text-xl font-bold">Gerenciar Escritores</h2>

                <button 
                    @click="open = !open" 
                    type="button" 
                    :class="open ? 'bg-gray-100 text-gray-600 border-gray-300' : 'border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white'"
                    class="border font-medium py-2 px-4 rounded transition duration-300"
                >
                    <span x-text="open ? 'Cancelar' : 'Adicionar Escritor'"></span>
                </button>
            </div>

            <div x-show="open" x-transition class="mb-8 p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <form action="{{ route('admin.newUser') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nome</label>
                            <input type="text" name="name" class="w-full border px-3 py-2 rounded text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nome completo" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">E-mail</label>
                            <input type="email" name="email" class="w-full border px-3 py-2 rounded text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="email@admin.com" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Senha Inicial</label>
                            <div class="flex gap-2">
                                <input type="password" name="password" class="w-full border px-3 py-2 rounded text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded text-sm font-bold hover:bg-blue-700 transition">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-left border-b border-gray-200">
                            <th class="p-3 text-sm font-semibold text-gray-600">ID</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Nome</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Email</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Bio</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Apagar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($writers as $writer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 text-sm text-gray-500">#{{ $writer->id }}</td>
                            <td class="p-3 text-sm font-medium">{{ $writer->name }}</td>
                            <td class="p-3 text-sm text-gray-600">{{ $writer->email }}</td>
                            <td class="p-3 text-sm text-gray-500 italic">{{ $writer->bio ?? 'Sem bio definida' }}</td>
                            <td class="p-3 text-sm">
                                <form action="{{ route('admin.deleteUser', $writer->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este escritor?')">
                                    @csrf
                                    @method('DELETE') <button type="submit" class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1 rounded text-xs font-semibold transition duration-300">
                                        Apagar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-400">Nenhum escritor cadastrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>