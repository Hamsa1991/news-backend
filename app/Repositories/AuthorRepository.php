<?php


namespace App\Repositories;


use App\Models\Author;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function All()
    {
        return Author::all();
    }

    // Find an Author by ID
    public function find($id)
    {
        return Author::findOrFail($id);
    }

    // Create a new Author
    public function create(array $data)
    {
        return Author::create($data);
    }

    // Update an existing Author
    public function update($id, array $data)
    {
        $Author = $this->find($id);
        $Author->update($data);
        return $Author;
    }

    // Delete an Author
    public function delete($id)
    {
        $Author = $this->find($id);
        return $Author->delete();
    }
}

