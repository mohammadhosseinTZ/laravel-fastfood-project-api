<?php

namespace App\Contracts\Interfaces;

interface CategoryRepository{
    public function getAll();
    public function create(array $categoryRequest);
    public function show(\App\Models\Category $category);
    public function delete(\App\Models\Category $category);
    public function update(\App\Models\Category $category , array $categoryRequest);
}