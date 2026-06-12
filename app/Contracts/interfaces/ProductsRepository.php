<?php

namespace App\Contracts\Interfaces;

interface ProductsRepository
{
    public function getAll();
    public function show(\App\Models\Product $product);
    public function update(\App\Models\Product $product, array $productRequest);
    public function destroy(\App\Models\Product $product);
    public function create(array $productRequest);
}
