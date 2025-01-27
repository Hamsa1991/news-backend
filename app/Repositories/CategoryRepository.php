<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function All()
    {
        return Category::all();
    }

    // Find an Category by ID
    public function find($id)
    {
        return Category::findOrFail($id);
    }

    // Create a new Category
    public function create(array $data)
    {
        return Category::create($data);
    }

    // Update an existing Category
    public function update($id, array $data)
    {
        $Category = $this->find($id);
        $Category->update($data);
        return $Category;
    }

    // Delete an Category
    public function delete($id)
    {
        $Category = $this->find($id);
        return $Category->delete();
    }
}
