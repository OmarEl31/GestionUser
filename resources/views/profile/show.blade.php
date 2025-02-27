@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Mon Profil</h2>
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <a href="{{ route('profile.edit') }}">Modifier</a>
    </div>
@endsection
