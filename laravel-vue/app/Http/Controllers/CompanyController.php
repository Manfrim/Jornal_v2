<?php 
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $escritor = Auth::guard('escritor')->user();

        if (!$escritor) {
            return redirect()->route('login.escritores')->with('error', 'Acesso negado.');
        }

        $totalArtigos = Materia::where('writer_id', $escritor->id)
                            ->where('status', 'publicado')
                            ->count();

        $totalViews = Materia::where('writer_id', $escritor->id)
                            ->sum('views');

        $companies = Company::with('writer')
                        ->orderBy('order', 'asc')
                        ->get();

        return view('admin.writers.dashboard', compact('escritor', 'totalArtigos', 'totalViews', 'companies'));
    }

    /**
     * Salva uma nova logo no banco
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'logo'  => 'required|image|mimes:svg,png,jpg,jpeg,webp|max:2048',
            'order' => 'nullable|integer',
        ]);

        try {
            $path = null;
            if ($request->hasFile('logo')) {
                // Salva o arquivo em storage/app/public/logos
                $path = $request->file('logo')->store('logos', 'public');
            }

            Company::create([
                'writer_id' => Auth::guard('escritor')->id(), // Registra o id do escritor atual
                'name'      => $request->name,
                'logo_path' => $path,
                'order'     => $request->order ?? 0,
                'is_active' => $request->has('is_active'),
            ]);

            return back()->with('success', 'Logo cadastrada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao salvar logo: ' . $e->getMessage());
            return back()->with('error', 'Erro ao salvar a logo no sistema.');
        }
    }

    /**
     * Remove a logo do banco e do disco de armazenamento
     */
    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);
            $escritor = Auth::guard('escritor')->user();

            // Só quem cadastrou a logo (ou admin/editor) pode excluir
            if ($company->writer_id !== $escritor->id && !in_array($escritor->role, ['admin', 'editor'])) {
                return back()->with('error', 'Você só pode excluir logos cadastradas por você.');
            }

            // Exclui a imagem física do Storage se ela existir
            if ($company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
                Storage::disk('public')->delete($company->logo_path);
            }

            $company->delete();

            return back()->with('success', 'Logo excluída com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao excluir logo: ' . $e->getMessage());
            return back()->with('error', 'Erro ao tentar remover a logo.');
        }
    }
}