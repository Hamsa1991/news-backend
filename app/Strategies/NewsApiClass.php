<?php


namespace App\Strategies;


use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsApiClass implements NewsApiInterface
{

    public function fetchArticles($url)
    {
        $data = Http::get($url)->json();
        if($data['articles']){
            foreach ($data['articles'] as $item){
                // Find or create the category
                if (empty($item['source']['name'])) {
                    throw new \Exception("Category name cannot be empty.");
                }
                $category = Category::firstOrCreate(['name' => $item['source']['name']]);
                if (!$category) {
                    throw new \Exception("Failed to create or retrieve a category.");
                }
                // Create the article
                $article = Article::create([
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                    'url' => $item['url'],
                    'url_to_image' => $item['urlToImage'] ?? null,
                    'published_at' => Carbon::createFromFormat('Y-m-d\TH:i:sO', $item['publishedAt']),
                    'category_id' => $category->id,
                ]);
                // Split authors by commas
                $authors = explode(',', $item['author']);

                if($authors) {
                    foreach ($authors as $authorName) {
                        $authorName = trim($authorName);

                        // Find or create the author
                        $author = Author::firstOrCreate(['name' => $authorName]);

                        // Attach author to article
                        $article->authors()->attach($author->id);
                    }
                }
            }
        }
        return $data['status'];
    }

}
