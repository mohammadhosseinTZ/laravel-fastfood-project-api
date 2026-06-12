<?php

namespace App\Repositories;

use App\Contracts\Interfaces\CategoryRepository;
use App\Models\Category;

class CategoryRepositoryImp implements CategoryRepository
{
    public function getAll()
    {
        return Category::latest()->paginate(2);
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function create(array $categoryRequest)
    {
        return Category::create($categoryRequest);
    }

    public function update(Category $category, array $categoryRequest)
    {
        $category->update($categoryRequest);
        return $categoryRequest;
    }

    public function delete(Category $category)
    {
        $category->delete();
        return $category;
    }
}
