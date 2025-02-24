<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer le terme de recherche depuis l'input
        $search = $request->input('search');

        // Récupérer les articles filtrés par recherche
        $articles = Article::where('title', 'like', "%$search%")
            ->orWhere('content', 'like', "%$search%")
            ->paginate(5); // Paginer à 5 articles par page

        // Retourner la vue avec les articles et la recherche
        return view('articles.index', compact('articles', 'search'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $article->update($request->all());

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
}
