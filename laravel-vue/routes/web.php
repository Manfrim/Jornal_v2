<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminWriterController;
use App\Http\Controllers\Writers;
use Illuminate\Support\Facades\Auth;


// Auth padrão do Laravel
Auth::routes();

// Home
Route::get('/', fn() => view('pages.home'));

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
    
    // ROTA QUE ESTAVA FALTANDO (Para salvar o artigo do Modal)
    Route::post('/painel/artigos/store', [Writers::class, 'store'])->name('panel.articles.store');
    
    // Rota de upload de imagem dentro do editor
    Route::post('/painel/upload-imagem', [Writers::class, 'uploadImageEditor'])->name('panel.image.upload');
});