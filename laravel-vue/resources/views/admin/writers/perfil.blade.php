<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - {{ config('app.name') }}</title>
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
                <a href="{{ route('panel.articles') }}" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-file-alt mr-3"></i> Meus Artigos
                </a>
                <a href="#" class="flex items-center py-3 px-6 bg-blue-600 text-white">
                    <i class="fas fa-user mr-3"></i> Perfil
                </a>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Editar Perfil</h2>
                <a href="{{ route('panel.writers') }}" class="text-gray-500 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
            </header>

            <div class="p-8 max-w-4xl mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm">
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('panel.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    @csrf
                    @method('PUT')

                    <div class="p-8 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="relative">
                                <img id="avatarPreview" 
                                     src="{{ $escritor->avatar ? asset('storage/' . $escritor->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($escritor->name) . '&background=0D8ABC&color=fff' }}" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
                                <label for="avatarInput" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700 shadow-lg transition">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*">
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">Sua Foto</h4>
                                <p class="text-gray-500 text-sm">Clique no ícone para alterar seu avatar. Recomendado: 400x400px.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo</label>
                                <input type="text" name="name" value="{{ old('name', $escritor->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">E-mail de Acesso</label>
                                <input type="email" name="email" value="{{ old('email', $escritor->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Biografia</label>
                                <textarea name="bio" rows="4" placeholder="Conte um pouco sobre você..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('bio', $escritor->bio) }}</textarea>
                            </div>

                            <hr class="md:col-span-2 my-2">

                            <div class="md:col-span-2">
                                <h4 class="text-gray-800 font-bold mb-1">Segurança</h4>
                                <p class="text-gray-500 text-sm mb-4">Deixe os campos abaixo em branco caso não queira alterar sua senha.</p>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nova Senha</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirmar Nova Senha</label>
                                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-4">
                        <button type="reset" class="px-6 py-2.5 text-gray-600 font-medium hover:bg-gray-200 rounded-lg transition">Descartar</button>
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md transition">
                            <i class="fas fa-save mr-2"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Preview da imagem em tempo real
        document.getElementById('avatarInput').onchange = function (evt) {
            const [file] = this.files
            if (file) {
                document.getElementById('avatarPreview').src = URL.createObjectURL(file)
            }
        }

        // Mostrar/Esconder Senha
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>