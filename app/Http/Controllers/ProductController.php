<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ProductsRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends ApiController
{
    protected $productRepository;
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productRepository = $productsRepository;
    }

    public function index()
    {
        return $this->successResponse(ProductResource::collection($this->productRepository->getAll()), 200, 'ok');
    }
    public function show(Product $product)
    {
        return $this->successResponse(new ProductResource($this->productRepository->show($product)), 200, 'ok');
    }
    public function store(ProductRequest $productRequest)
    {
        DB::beginTransaction();

        $imageName = Carbon::now()->microsecond . '-' . $productRequest->primary_image->getClientOriginalName();
        $productRequest->primary_image->storeAs("images/products", $imageName, 'public');

        $imagesFileStorage = [];

        if ($productRequest->hasFile('images')) {

            foreach ($productRequest->images as $imageFileStorage) {

                $imgName = Carbon::now()->microsecond . '-' . $imageFileStorage->getClientOriginalName();

                $imageFileStorage->storeAs(
                    "images/products",
                    $imgName,
                    'public'
                );

                $imagesFileStorage[] = $imgName;
            }
        }

        $data = $productRequest->validated();

        $data['primary_image'] = $imageName;
        $data['images'] = $imagesFileStorage;

        $product = $this->productRepository->create($data);

        DB::commit();
        return $this->successResponse(new ProductResource($product), 201, 'ok');
    }
    public function update(Product $product, ProductUpdateRequest $productUpdateRequest)
    {
        DB::beginTransaction();

        if ($productUpdateRequest->primary_image !== null && $productUpdateRequest->has('primary_image')) {

            Storage::disk('public')->delete(
                'images/products/' . $product->primary_image
            );

            $imageName = Carbon::now()->microsecond . '-' . $productUpdateRequest->primary_image->getClientOriginalName();
            $productUpdateRequest->primary_image->storeAs("images/products/", $imageName, 'public');
        }

        $imagesFileStorage = [];

        if ($productUpdateRequest->hasFile('images')) {

            foreach ($product->images as $image) {

                Storage::disk('public')->delete(
                    'images/products/' . $image->image
                );
            }

            foreach ($productUpdateRequest->images as $imageFileStorage) {

                $imgName = Carbon::now()->microsecond . '-' . $imageFileStorage->getClientOriginalName();

                $imageFileStorage->storeAs(
                    "images/products",
                    $imgName,
                    'public'
                );

                $imagesFileStorage[] = $imgName;
            }
        }

        $data = $productUpdateRequest->validated();

        $data['primary_image'] =  $productUpdateRequest->hasFile('primary_image') ?  $imageName : $product->primary_image;


        if (!empty($imagesFileStorage)) {
            $data['images'] = $imagesFileStorage;
        }

        $product = $this->productRepository->update($product, $data);
        DB::commit();

        return $this->successResponse(new ProductResource($product), 200, 'ok');
    }

    public function destroy(Product $product)
    {

        Storage::disk('public')->delete('images/products/' . $product->primary_image);

        foreach ($product->images as $image) {

            Storage::disk('public')->delete(
                'images/products/' . $image->image
            );
        }

        $resutl = $this->productRepository->destroy($product);
        return $this->successResponse(new ProductResource($resutl), 200, 'ok');
    }
}
