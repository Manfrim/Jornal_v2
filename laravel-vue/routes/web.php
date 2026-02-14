<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminWriterController;
use App\Http\Controllers\Writers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicController;


// Auth padrão do Laravel
Auth::routes();

// Home
Route::get('/', [PublicController::class, 'index'])->name('home');

//APIs
Route::get('/api/materias/recentes', [PublicController::class, 'getRecentes']);
Route::get('/api/materias/populares', [PublicController::class, 'getPopulares']);

// Login admin master
Route::get('/login', fn() => view('admin.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin master
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminWriterController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/newUser',  [AdminWriterController::class, 'NewUser'])->name('admin.newUser');
    Route::delete('/admin/escritores/{id}', [AdminWriterController::class, 'deleteUser'])->name('admin.deleteUser');
}); 


// Login escritores
Route::get('/login/escritor', fn() => view('admin.writers.login_escritor'))->name('login.escritores');
Route::post('/login/escritor', [Writers::class, 'login'])->name('login.post.escritorio');

// Pagina de admin dos escritores
// Ajustei o middleware para 'auth:escritor' caso você esteja usando Guard separado
Route::middleware(['auth:escritor', 'is.writer'])->group(function () {
    Route::get('/painel', [Writers::class, 'dashboard'])->name('panel.writers');

    // Listagem de artigos
    Route::get('/painel/artigos', [Writers::class, 'articles'])->name('panel.articles');
    
    // Salvar o artigo do Modal
    Route::post('/painel/artigos/store', [Writers::class, 'store'])->name('panel.articles.store');
    
    // Rota de upload de imagem dentro do editor
    Route::post('/painel/upload-imagem', [Writers::class, 'uploadImageEditor'])->name('panel.image.upload');

    // NOVA ROTA DE EXCLUSÃO (Adicionada aqui)
    Route::delete('/painel/artigos/{id}', [Writers::class, 'destroy'])->name('panel.articles.destroy');

    Route::put('/painel/artigos/update/{id}', [Writers::class, 'update'])->name('panel.articles.update');

    Route::get('/painel/perfil', [Writers::class, 'editProfile'])->name('panel.perfil');

    Route::put('/painel/perfil/update', [Writers::class, 'updateProfile'])->name('panel.profile.update');
});