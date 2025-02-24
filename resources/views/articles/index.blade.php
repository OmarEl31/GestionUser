@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des Articles</h1>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('articles.index') }}" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Rechercher un article..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
    </form>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Liste des articles -->
    @if($articles->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Contenu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ Str::limit($article->content, 50) }}</td>
                        <td>
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $articles->links() }}
    @else
        <p>Aucun article trouvé.</p>
    @endif
</div>
@endsection
