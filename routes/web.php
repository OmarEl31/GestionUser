<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;

// ============================
//  Page d'accueil
// ============================
Route::get('/', function () {
    return view('welcome');
});

// ============================
//  Redirection post-connexion selon le rôle
// ============================
Route::get('/home', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->hasRole('user')) {
        return redirect()->route('user.dashboard');
    }
    return redirect('/dashboard');
})->middleware(['auth'])->name('home');

// ============================
//  Dashboard Administrateur
// ============================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Gestion des utilisateurs (Admins uniquement)
    Route::resource('users', UserController::class);

    // Attribution des rôles aux utilisateurs
    Route::get('/assign-role/{userId}/{roleName}', [UserController::class, 'assignRoleToUser'])->name('assign.role');
});

// ============================
//  Dashboard Utilisateur
// ============================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// ============================
//  Dashboard général (Tous utilisateurs connectés)
// ============================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================
//  Gestion des Articles
// ============================
// Accessible à tous les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::resource('articles', ArticleController::class);
});

// Permissions spécifiques aux actions sur les articles
Route::middleware(['auth', 'permission:publish articles'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
});

Route::middleware(['auth', 'permission:delete articles'])->group(function () {
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// ============================
//  Gestion du Profil Utilisateur
// ============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================
//  Authentification Laravel Breeze
// ============================
require __DIR__ . '/auth.php';
