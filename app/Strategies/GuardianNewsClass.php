<?php


namespace App\Strategies;


use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GuardianNewsClass implements NewsApiInterface
{
    public function fetchArticles($url)
    {
        $data = Http::get($url)->json();
        if (isset($data['response']['results'])) {
            foreach ($data['response']['results'] as $item) {


                // Find or create the category
                $category = Category::firstOrCreate(['name' => $item['sectionName']]);

                // Create the article
                Article::create([
                    'title' => $item['webTitle'],
                    'description' => $item['description'] ?? null,
                    'url' => $item['webUrl'],
                    'url_to_image' => $item['urlToImage'] ?? null,
                    'published_at' => Carbon::createFromFormat('Y-m-d\TH:i:sO', $item['webPublicationDate']),
                    'category_id' => $category->id,
                ]);

            }

        }
        return $data['response']['status'];
    }
}
