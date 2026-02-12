<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Artigos - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
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
                <a href="{{ route('panel.articles') }}" class="flex items-center py-3 px-6 bg-blue-600 text-white">
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
                    <button onclick="toggleModal('articleModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold flex items-center transition shadow-md">
                        <i class="fas fa-plus mr-2"></i> Novo Artigo
                    </button>
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
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($materia->capa)
                                                <img src="{{ asset('storage/' . $materia->capa) }}" class="w-10 h-10 rounded object-cover mr-3">
                                            @endif
                                            <span class="text-gray-800 font-medium">{{ $materia->titulo }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded uppercase tracking-wider">{{ $materia->categoria ?? 'Geral' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($materia->status == 'publicado')
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold italic">Publicado</span>
                                        @else
                                            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-bold italic">Rascunho</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">
                                        {{ $materia->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-3 text-lg">
                                            <a href="#" class="text-blue-500 hover:text-blue-700" title="Editar"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="text-red-500 hover:text-red-700" title="Excluir"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-medium">
                                        <i class="fas fa-folder-open text-4xl mb-3 block"></i>
                                        Nenhuma matéria encontrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="articleModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black bg-opacity-60 transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden transform transition-all">
                
                <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800">Criar Nova Matéria</h3>
                    <button onclick="toggleModal('articleModal')" class="text-gray-400 hover:text-gray-600 transition text-3xl">&times;</button>
                </div>

                <form action="{{ route('panel.articles.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Título da Matéria</label>
                            <input type="text" name="titulo" required placeholder="Digite o título principal" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Categoria</label>
                            <input type="text" name="categoria" placeholder="Ex: Tecnologia" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Inicial</label>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition cursor-pointer">
                                <option value="rascunho">Rascunho</option>
                                <option value="publicado">Publicado</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Imagem de Capa (Destaque)</label>
                            <label class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 rounded-lg hover:bg-gray-50 transition cursor-pointer group">
                                <div class="flex flex-col items-center justify-center pt-7">
                                    <i class="fas fa-image text-gray-400 text-3xl group-hover:text-blue-500 transition mb-2"></i>
                                    <p class="text-sm text-gray-400">Clique aqui para enviar a capa</p>
                                </div>
                                <input type="file" name="capa" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Corpo do Artigo</label>
                        <textarea name="conteudo" id="editor"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 border-t pt-6">
                        <button type="button" onclick="toggleModal('articleModal')" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                            Cancelar
                        </button>
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-bold shadow-lg">
                            Salvar Matéria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(modalID) {
            const modal = document.getElementById(modalID);
            modal.classList.toggle('hidden');
            document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
        }

        tinymce.init({
            selector: '#editor',
            // ... suas outras configurações (plugins, toolbar, etc)
            images_upload_url: "{{ route('panel.image.upload') }}",
            automatic_uploads: true,
            
            // VERSÃO CORRIGIDA COM PROMISE
            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', "{{ route('panel.image.upload') }}");

                xhr.onload = () => {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }

                    const json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed due to a Network Error.');
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('_token', '{{ csrf_token() }}');

                xhr.send(formData);
            })
        });
    </script>
</body>
</html>