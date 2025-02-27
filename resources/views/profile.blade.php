@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gérer mon profil</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe (laisser vide si inchangé)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Es-tu sûr de vouloir supprimer ton compte ? Cette action est irréversible.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
        </form>
    </div>
</div>
@endsection
