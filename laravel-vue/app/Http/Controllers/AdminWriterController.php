<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminWriterController extends Controller
{
    /**
     * Exibe o dashboard com a lista de escritores.
     */
    public function dashboard()
    {
        // Pega todos os registros da tabela 'escritores'
        $writers = Writer::all();

        return view('admin.dashboard', compact('writers'));
    }

    /**
     * Cria um novo escritor na tabela 'escritores'.
     */
    public function newUser(Request $request)
    {
        // 1. Validação (Apontando para a tabela 'escritores')
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:escritores,email',
            'password' => 'required|min:6',
        ], [
            'email.unique' => 'Este e-mail já está cadastrado como escritor.'
        ]);

        // 2. Criação usando o Model Writer
        // Nota: Se no seu Model Writer o cast de password for 'hashed', 
        // o Laravel cuida do Hash automaticamente.
        Writer::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], 
            'role'     => 'writer',
            'bio'      => 'Novo escritor', // Valor padrão caso não venha no form
        ]);

        return redirect()->back()->with('success', 'Escritor cadastrado com sucesso!');
    }
    public function deleteUser($id)
    {
        // 1. Busca o escritor pelo ID ou retorna erro 404 se não existir
        $writer = Writer::findOrFail($id);

        // 2. Deleta o registro
        $writer->delete();

        // 3. Redireciona de volta com mensagem
        return redirect()->back()->with('success', 'Escritor removido com sucesso!');
    }
}