@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'utilisateur</h2>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <label>Nom :</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>

        <label>Email :</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>

        <button type="submit" class="btn btn-success mt-2">Enregistrer</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
