@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Bienvenue, {{ Auth::user()->name }} !</p>

    <a href="{{ route('users.index') }}" class="btn btn-primary">Gérer les utilisateurs</a>
    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Gérer les articles</a>
</div>
@endsection
