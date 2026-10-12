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
                <a href="{{ route('panel.companies.index') }}" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-building mr-3"></i> Logos Empresas
                </a>
                <a href="{{route('panel.perfil')}}" class="flex items-center py-3 px-6 text-gray-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-user mr-3"></i> Perfil
                </a>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Gerenciar Artigos</h2>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600 transition">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Minhas Matérias</h3>
                        <p class="text-gray-500 text-sm">Você possui {{ $materias->count() }} artigos cadastrados.</p>
                    </div>
                    <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold flex items-center transition shadow-md">
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
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($materias as $materia)
                                {{-- Adicionamos a classe 'article-row' e o data-status para o filtro funcionar --}}
                                <tr class="hover:bg-gray-50 transition article-row" data-status="{{ $materia->status }}">
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $materia->titulo }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-1 rounded font-bold uppercase tracking-wider">
                                            {{ $materia->categoria ?? 'Geral' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs {{ $materia->status == 'publicado' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} px-2 py-1 rounded-full font-bold">
                                            {{ ucfirst($materia->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-4">
                                            {{-- 1. Botão de Preview (Olhinho) --}}
                                            <a href="{{ route('panel.articles.preview', $materia->id) }}" 
                                            target="_blank" 
                                            class="text-gray-400 hover:text-blue-600 transition-colors" 
                                            title="Visualizar como está ficando">
                                                <i class="fas fa-eye text-lg"></i>
                                            </a>

                                            {{-- 2. Botão Editar --}}
                                            <button onclick="openEditModal({{ $materia->toJson() }})" 
                                                    class="text-blue-500 hover:text-blue-700 transition-colors"
                                                    title="Editar matéria">
                                                <i class="fas fa-edit text-lg"></i>
                                            </button>

                                            {{-- 3. Botão Excluir --}}
                                            <form action="{{ route('panel.articles.destroy', $materia->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta matéria?')">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Excluir permanentemente">
                                                    <i class="fas fa-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                        <i class="fas fa-folder-open block text-3xl mb-3 opacity-20"></i>
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
        <div class="fixed inset-0 bg-black bg-opacity-60"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                    <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Nova Matéria</h3>
                    <button onclick="toggleModal('articleModal')" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
                </div>

                <form id="articleForm" action="" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div id="methodField"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Título</label>
                            <input type="text" name="titulo" id="edit_titulo" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Categoria</label>
                            <input type="text" name="categoria" id="edit_categoria" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <div class="flex items-center h-10">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="status_toggle" class="sr-only peer" onchange="updateStatusValue(this)">
                                    <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span id="status_text" class="ml-3 text-sm font-medium text-gray-600">Rascunho</span>
                                </label>
                                <input type="hidden" name="status" id="edit_status" value="rascunho">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Capa (Opcional na edição)</label>
                            <input type="file" name="capa" accept="image/*" class="w-full">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Conteúdo</label>
                        <textarea name="conteudo" id="editor"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 border-t pt-6">
                        <button type="button" onclick="toggleModal('articleModal')" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancelar</button>
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold">Salvar Matéria</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 1. Inicialização do TinyMCE
        tinymce.init({
            selector: '#editor',
            plugins: 'image code table lists',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | image | code',
            images_upload_url: "{{ route('panel.image.upload') }}",
            automatic_uploads: true,
            images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('panel.image.upload') }}");
                xhr.onload = () => {
                    const json = JSON.parse(xhr.responseText);
                    if (json && json.location) resolve(json.location);
                    else reject('Erro no upload');
                };
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('_token', '{{ csrf_token() }}');
                xhr.send(formData);
            })
        });

        // 2. Funções do Modal e UI
        function toggleModal(modalID) {
            const modal = document.getElementById(modalID);
            modal.classList.toggle('hidden');
            document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
        }

        function updateStatusValue(checkbox) {
            const statusInput = document.getElementById('edit_status');
            const statusText = document.getElementById('status_text');
            
            if (checkbox.checked) {
                statusInput.value = 'publicado';
                statusText.innerText = 'Publicado';
                statusText.classList.remove('text-gray-600');
                statusText.classList.add('text-blue-600');
            } else {
                statusInput.value = 'rascunho';
                statusText.innerText = 'Rascunho';
                statusText.classList.remove('text-blue-600');
                statusText.classList.add('text-gray-600');
            }
        }

        function openCreateModal() {
            document.getElementById('modalTitle').innerText = "Criar Nova Matéria";
            const form = document.getElementById('articleForm');
            form.action = "{{ route('panel.articles.store') }}";
            document.getElementById('methodField').innerHTML = "";
            form.reset();

            // Reset do Toggle
            const toggle = document.getElementById('status_toggle');
            toggle.checked = false;
            updateStatusValue(toggle);

            if (tinymce.get('editor')) tinymce.get('editor').setContent('');
            toggleModal('articleModal');
        }

        function openEditModal(materia) {
            document.getElementById('modalTitle').innerText = "Editar Matéria";
            const form = document.getElementById('articleForm');
            form.action = `/painel/artigos/update/${materia.id}`;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('edit_titulo').value = materia.titulo;
            document.getElementById('edit_categoria').value = materia.categoria || '';
            
            // Sincronizar Toggle
            const toggle = document.getElementById('status_toggle');
            toggle.checked = (materia.status === 'publicado');
            updateStatusValue(toggle);
            
            if (tinymce.get('editor')) {
                tinymce.get('editor').setContent(materia.conteudo || '');
            }
            toggleModal('articleModal');
        }

        
    </script>
</body>
</html>