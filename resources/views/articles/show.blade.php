@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $article->title }}</h2>
    <p>{{ $article->content }}</p>
    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
