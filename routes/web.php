<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Routes de l'application
|--------------------------------------------------------------------------
| Fichier principal des routes de l'application.
| Organisé par fonctionnalité selon le projet actuel.
*/

// ============================
// 🌐 Routes publiques
// ============================

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');
//Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});
// ============================
// 🔒 Authentification & Vérification
// ============================

// Vérification d'email
Route::get('/email/verify', EmailVerificationPromptController::class)
    ->middleware('auth')
    ->name('verification.notice');

// Dashboard général pour les utilisateurs connectés
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ============================
// 👑 Routes Administrateur (Gestion des utilisateurs et rôles)
// ============================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Administrateur
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Gestion des utilisateurs
    Route::resource('users', UserController::class);

    // Attribution des rôles aux utilisateurs
    Route::get('/assign-role/{userId}/{roleName}', [UserController::class, 'assignRoleToUser'])
        ->name('assign.role');

    // Journal des activités des utilisateurs
    Route::get('/users/{user}/activity-logs', [UserController::class, 'activityLogs'])->name('users.activity_logs');
});

// ============================
// 👤 Routes Utilisateur Standard
// ============================
Route::middleware(['auth', 'role:user'])->group(function () {
    // Dashboard Utilisateur
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});



// ============================
// ⚙️ Gestion du profil utilisateur
// ============================

// ============================
// 🔐 Authentification Laravel Breeze
// ============================
require __DIR__ . '/auth.php';
