<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Rediriger les utilisateurs après connexion vers le bon dashboard
Route::get('/home', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->hasRole('user')) {
        return redirect()->route('user.dashboard');
    }
    return redirect('/dashboard');
})->middleware(['auth'])->name('home');

//  Routes pour les administrateurs
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

//  Routes pour les utilisateurs normaux
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//  Gestion des utilisateurs (uniquement pour les administrateurs)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

//  Gestion du profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentification Laravel Breeze
require __DIR__.'/auth.php';
