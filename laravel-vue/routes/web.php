<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminWriterController;
use App\Http\Controllers\Writers;
use Illuminate\Support\Facades\Auth;


// Auth
Auth::routes();

// Home
Route::get('/', fn() => view('pages.home'));

// Login admin master
Route::get('/login', fn() => view('admin.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin master (apenas uma rota!)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminWriterController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/newUser',  [AdminWriterController::class, 'NewUser'])->name('admin.newUser');
    Route::delete('/admin/escritores/{id}', [AdminWriterController::class, 'deleteUser'])->name('admin.deleteUser');
}); 


//Login escritores
Route::get('/login', fn() => view('admin.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// pagina de admin dos escritores
Route::middleware(['auth', 'is.writer'])->group(function () {
    Route::get('/painel', [Writers::class, 'dashboard'])->name('panel.writers');
    // ... outras rotas
});
