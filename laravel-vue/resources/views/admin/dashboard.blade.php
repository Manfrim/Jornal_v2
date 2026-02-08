<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex flex-col">

    <!-- Navbar -->
    <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Painel Admin</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Sair
            </button>
        </form>
    </header>

    <!-- Conteúdo principal -->
    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Bem-vindo, {{ auth()->user()->name }}!</h2>
            <p class="mb-2">
                Você está logado como: 
                <span class="font-bold">{{ auth()->user()->is_admin ? 'Administrador' : 'Usuário' }}</span>
            </p>

            {{-- Exemplo de cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-blue-100 p-4 rounded-lg shadow">
                    <h3 class="font-semibold">Usuários</h3>
                    <p class="text-2xl mt-2">42</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg shadow">
                    <h3 class="font-semibold">Posts</h3>
                    <p class="text-2xl mt-2">128</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg shadow">
                    <h3 class="font-semibold">Comentários</h3>
                    <p class="text-2xl mt-2">512</p>
                </div>
            </div>
        </div>
        <h1 class="text-2xl font-bold mb-4">Painel do Admin</h1>

        <table class="w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Nome</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Bio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($writers as $writer)
                <tr>
                    <td class="p-2 border">{{ $writer->id }}</td>
                    <td class="p-2 border">{{ $writer->name }}</td>
                    <td class="p-2 border">{{ $writer->email }}</td>
                    <td class="p-2 border">{{ $writer->bio }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>
</html>
