<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


// ============================
//  Page d'accueil
// ============================
Route::get('/', function () {
    return view('welcome');
}); 

// ============================
//  Rediriger les utilisateurs après connexion vers leur dashboard
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
//  Dashboard Administrateur (Accès réservé aux admins)
// ============================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// ============================
//  Dashboard Utilisateur (Accès réservé aux utilisateurs classiques)
// ============================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// ============================
//  Dashboard général accessible à tous les utilisateurs authentifiés
// ===========================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================
//  Gestion des articles (Accessible à tous les utilisateurs connectés)
// ============================
Route::middleware(['auth'])->group(function () {
    Route::resource('articles', ArticleController::class);
});

//  Ajout de permissions spécifiques sur certaines actions des articles
Route::middleware(['auth', 'permission:publish articles'])->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
});

// ============================
//  Gestion des utilisateurs (Accès réservé aux admins)
// ============================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

//  Attribution d'un rôle à un utilisateur spécifique (Admin uniquement)
Route::middleware(['auth', 'role:admin'])->get('/assign-role/{userId}/{roleName}', [UserController::class, 'assignRoleToUser']);

// ============================
//  Gestion du profil utilisateur (Accessible à tous les utilisateurs authentifiés)
// ============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================
//  Authentification Laravel Breeze
// ============================
