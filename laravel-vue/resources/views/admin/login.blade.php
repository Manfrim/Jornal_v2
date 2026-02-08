<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login | Painel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Painel Admin
            </h1>
            <p class="text-gray-500 mt-2">
                Faça login para continuar
            </p>
        </div>

        {{-- Mensagem de erro --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 p-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    autofocus
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="seu@email.com"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Senha
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center justify-between text-sm text-gray-600">
                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    >
                    Lembrar de mim
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition"
            >
                Entrar
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-8">
            © {{ date('Y') }} Painel Administrativo
        </p>
    </div>

</body>
</html>
