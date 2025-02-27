@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Modifier mon profil</h2>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Nom :</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            <button type="submit">Mettre à jour</button>
        </form>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Êtes-vous sûr ?')">Supprimer mon compte</button>
        </form>
    </div>
@endsection
