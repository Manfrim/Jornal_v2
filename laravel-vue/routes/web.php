<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminWriterController;
use Illuminate\Support\Facades\Auth;

// Auth
Auth::routes();

// Home
Route::get('/', fn() => view('pages.home'));

// Login
Route::get('/login', fn() => view('admin.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin (apenas uma rota!)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminWriterController::class, 'dashboard'])->name('admin.dashboard');
});
