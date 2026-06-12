<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\CategoryRepository;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index()
    {
        return $this->successResponse([
            'categories' => CategoryResource::collection($this->categoryRepository->getAll()),
            'links' => CategoryResource::collection($this->categoryRepository->getAll())->response()->getData()->links,
            'meta' => CategoryResource::collection($this->categoryRepository->getAll())->response()->getData()->meta,
        ], 200, 'ok');
    }
    public function show(Category $category)
    {
        return $this->successResponse(new CategoryResource($this->categoryRepository->show($category)), 200, 'ok');
    }
    public function store(CategoryRequest $categoryRequest)
    {
        $result = $this->categoryRepository->create($categoryRequest->validated());
        return $this->successResponse(new CategoryResource($result), 201, 'ok');
    }
    public function update(Category $category, CategoryRequest $categoryRequest)
    {
        $result = $this->categoryRepository->update($category, $categoryRequest->validated());
        return $this->successResponse(new CategoryResource($result), 200, 'ok');
    }
    public function destroy(Category $category)
    {
        return $this->successResponse(new CategoryResource($this->categoryRepository->delete($category)), 200, 'ok');
    }
}
