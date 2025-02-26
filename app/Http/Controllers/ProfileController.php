<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Afficher la page d'édition du profil.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Mettre à jour les informations du profil de l'utilisateur.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Mise à jour des données de l'utilisateur
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Supprimer le compte utilisateur.
     */
    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();

        $user->delete();

        return redirect('/')->with('success', 'Compte supprimé avec succès.');
    }
}
