<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['author_id', 'category_id', 'published_at']);
            $articles = $this->articleRepository->latest($filters);

            return ArticleResource::collection($articles);
        } catch (\Exception $exception) {
            Log::error("Error in retrieving articles" . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving articles.'], 500);
        }
    }

    public function getArticlesByAuthors(Request $request)
    {
        try {
            $articles = $this->articleRepository->getArticlesByAuthors();
            return response()->json(['articles' => ArticleResource::collection($articles)], 200);

        } catch (\Exception $exception) {
            Log::error("Error in retrieving articles by favorite authors: " . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving articles.'], 500);
        }
    }

    public function getArticlesByCategories(Request $request)
    {

        try {
            $articles = $this->articleRepository->getArticlesByCategories();

            return response()->json(['articles' => ArticleResource::collection($articles)], 200);

        } catch (\Exception $exception) {
            Log::error("Error in retrieving articles by favorite categories: " . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving articles.'], 500);
        }
    }
}

