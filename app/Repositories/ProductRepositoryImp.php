<?php

namespace App\Repositories;

use App\Contracts\Interfaces\ProductsRepository;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductRepositoryImp implements ProductsRepository
{
    public function getAll()
    {
        return Product::with(['category' , 'images'])->get();
    }
    public function show(Product $product)
    {
        return $product->load(['category' , 'images']);
    }
    public function create(array $productRequest)
    {
       

        $images = $productRequest['images'] ?? [];

        unset($productRequest['images']);

        $product = Product::create($productRequest);

        if (!empty($images)) {

            foreach ($images as $image) {

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image
                ]);
            }
        }
     

        return $product->load(['category' , 'images']);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        $product->images()->delete();
        return $product;
    }
    public function update(Product $product, array $productRequest)
    {
       

        $images = $productRequest['images'] ?? [];

        unset($productRequest['images']);


        $product->update($productRequest);

        if ($images !== null) {

            $product->images()->delete();
        
            foreach ($images as $image) {
        
                $product->images()->create([
                    'image' => $image
                ]);
            }
        }
    

        return $product->load(['category' , 'images']);
    }
}
