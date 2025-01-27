<?php
// app/Repositories/ArticleRepository.php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    // Fetch all articles with optional filters
    public function latest($filters = [])
    {
        $author_id = $filters['author_id'] ?? null;
        $category_id = $filters['category_id'] ?? null;
        $published_at = $filters['published_at'] ?? null;


        return Article::with(['authors', 'category'])
            ->when($author_id, function ($query) use ($author_id) {
                return $query->whereHas('authors', function ($subQuery) use ($author_id) {
                    $subQuery->where('authors.id', $author_id);
                });
            })
            ->when($category_id, function ($query) use ($category_id) {
                return $query->where('category_id', $category_id);
            })
            ->when($published_at, function ($query) use ($published_at) {
                return $query->whereDate('published_at', $published_at);
            })
            ->orderByDesc('published_at')
            ->paginate(10);
    }

    public function getArticlesByCategories()
    {
        $user = auth()->user();

        // Get the IDs of the favorite Categories
        $favoriteCategoryIds = $user->favoriteCategories()->pluck('categories.id');

        // Fetch articles written by those categories
        return Article::whereHas('category', function ($query) use ($favoriteCategoryIds) {
            $query->whereIn('category_id', $favoriteCategoryIds);
        })->paginate(10);
    }

    public function getArticlesByAuthors()
    {
        // Assuming the user is authenticated
        $user = auth()->user();

        // Get the IDs of the favorite authors
        $favoriteAuthorIds = $user->favoriteAuthors()->pluck('authors.id');

        // Fetch articles written by those authors
        return Article::whereHas('authors', function ($query) use ($favoriteAuthorIds) {
            $query->whereIn('authors.id', $favoriteAuthorIds);
        })->paginate(10);
    }

    // Find an article by ID
    public function find($id)
    {
        return Article::findOrFail($id);
    }

    // Create a new article
    public function create(array $data)
    {
        return Article::create($data);
    }

    // Update an existing article
    public function update($id, array $data)
    {
        $article = $this->find($id);
        $article->update($data);
        return $article;
    }

    // Delete an article
    public function delete($id)
    {
        $article = $this->find($id);
        return $article->delete();
    }
}

