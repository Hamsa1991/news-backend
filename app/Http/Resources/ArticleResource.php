<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'content' => $this->content,
        'url' => $this->url,
        'urlToImage' => $this->urlToImage,
        'publishedAt' => $this->publishedAt,
        'category_id' => $this->category_id,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
    ];;
    }
}

