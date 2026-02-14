<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Writer;
use App\Models\Materia; // Certifique-se de que o Model se chama Materia

class Writers extends Controller
{
    /**
     * Realiza o login do escritor
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('escritor')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('panel.writers'));
        }

        return back()->withErrors(['email' => 'Credenciais inválidas para escritor.']);
    }

    /**
     * Exibe o dashboard principal
     */
    public function dashboard()
    {
        $escritor = Auth::guard('escritor')->user();

        if (!$escritor) {
            return redirect()->route('login.escritores')->with('error', 'Acesso negado.');
        }

        return view('admin.writers.dashboard', [
            'escritor' => $escritor
        ]);
    }

    /**
     * Lista os artigos do escritor logado
     */
    public function articles()
    {
        $escritor = Auth::guard('escritor')->user();
        
        // Carrega as matérias usando o relacionamento definido no Model Writer
        $materias = $escritor->materias()->latest()->get();

        return view('admin.writers.dashboard_Artigos', compact('escritor', 'materias'));
    }

    /**
     * Salva uma nova matéria no banco de dados
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'    => 'required|max:255',
            'conteudo'  => 'required',
            'categoria' => 'nullable|string',
            'status'    => 'required|in:rascunho,publicado',
            'capa'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $escritor = Auth::guard('escritor')->user();

            // Tratamento da Imagem de Capa (Destaque)
            $capaPath = null;
            if ($request->hasFile('capa')) {
                $capaPath = $request->file('capa')->store('uploads/capas', 'public');
            }

            // Criação da Matéria
            $materia = new Materia();
            $materia->titulo      = $request->titulo;
            $materia->slug        = Str::slug($request->titulo) . '-' . time();
            $materia->conteudo    = $request->conteudo;
            $materia->categoria   = $request->categoria;
            $materia->status      = $request->status;
            $materia->capa        = $capaPath;
            $materia->writer_id   = $escritor->id; // Ajuste para o nome da sua FK (escritor_id ou writer_id)
            $materia->save();

            return redirect()->route('panel.articles')->with('success', 'Matéria publicada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao salvar matéria: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erro ao salvar a matéria. Verifique os logs.');
        }
    }

    /**
     * Handler para upload de imagens via TinyMCE (Editor)
     */
    public function uploadImageEditor(Request $request)
    {
        try {
            Log::info('Iniciando upload de imagem via editor.');

            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                Log::info('Arquivo recebido para o editor:', [
                    'nome' => $file->getClientOriginalName(),
                    'tamanho' => $file->getSize()
                ]);

                $path = $file->store('uploads/editor', 'public');
                $url = asset('storage/' . $path);

                Log::info('Upload do editor concluído: ' . $url);

                return response()->json(['location' => $url]);
            }

            return response()->json(['error' => 'Arquivo não enviado'], 400);

        } catch (\Illuminate\Validation\ValidationException $v) {
            Log::error('Validação falhou no upload do editor:', $v->errors());
            return response()->json(['error' => 'Validação falhou', 'details' => $v->errors()], 422);

        } catch (\Exception $e) {
            Log::error('Erro crítico no upload do editor: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno no servidor'], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $materia = Materia::findOrFail($id);

            // Segurança: só o dono da matéria pode excluir
            if ($materia->writer_id !== Auth::guard('escritor')->id()) {
                return back()->with('error', 'Acesso negado!');
            }

            // Apaga a imagem de capa física se existir
            if ($materia->capa) {
                Storage::disk('public')->delete($materia->capa);
            }

            $materia->delete();

            return redirect()->route('panel.articles')->with('success', 'Matéria excluída com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao excluir: ' . $e->getMessage());
            return back()->with('error', 'Erro ao excluir a matéria.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo'    => 'required|max:255',
            'conteudo'  => 'required',
            'categoria' => 'nullable|string',
            'status'    => 'required|in:rascunho,publicado',
            'capa'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $materia = Materia::findOrFail($id);

            // Segurança: Verifica se a matéria pertence ao escritor
            if ($materia->writer_id !== Auth::guard('escritor')->id()) {
                return back()->with('error', 'Acesso negado!');
            }

            // Se enviou nova capa, deleta a antiga e salva a nova
            if ($request->hasFile('capa')) {
                if ($materia->capa) {
                    Storage::disk('public')->delete($materia->capa);
                }
                $materia->capa = $request->file('capa')->store('uploads/capas', 'public');
            }

            $materia->titulo    = $request->titulo;
            $materia->slug      = Str::slug($request->titulo) . '-' . time();
            $materia->conteudo  = $request->conteudo;
            $materia->categoria = $request->categoria;
            $materia->status    = $request->status;
            $materia->save();

            return redirect()->route('panel.articles')->with('success', 'Matéria atualizada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar: ' . $e->getMessage());
            return back()->with('error', 'Erro ao salvar as alterações.');
        }
    }

    public function editProfile()
    {
        $escritor = Auth::guard('escritor')->user();
        return view('admin.writers.perfil', compact('escritor'));
    }
    
    public function updateProfile(Request $request)
    {
        // MUDANÇA AQUI: Captura o usuário do guard correto
        $escritor = Auth::guard('escritor')->user(); 

        if (!$escritor) {
            return redirect()->route('login.escritores')->with('error', 'Sessão expirada.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            // Note que o unique aponta para a tabela 'escritores'
            'email' => 'required|email|unique:escritores,email,' . $escritor->id,
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $escritor->name = $request->name;
        $escritor->email = $request->email;
        $escritor->bio = $request->bio;

        if ($request->filled('password')) {
            $escritor->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($escritor->avatar) {
                Storage::disk('public')->delete($escritor->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $escritor->avatar = $path;
        }

        $escritor->save();

        // Redireciona de volta para a rota de edição com sucesso
        return redirect()->route('panel.perfil')->with('success', 'Perfil atualizado com sucesso!');
    }
}