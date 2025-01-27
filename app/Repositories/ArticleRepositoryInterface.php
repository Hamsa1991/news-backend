<?php
namespace App\Repositories;

use App\Models\Article;

interface ArticleRepositoryInterface
{
    public function latest($filters = []); // Fetch all articles with optional filters
    public function getArticlesByAuthors();
    public function getArticlesByCategories();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}

