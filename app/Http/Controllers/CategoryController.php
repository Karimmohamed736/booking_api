<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Services\CategoryService;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)  //service
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        //service for clean code
        $categories = $this->categoryService->index();

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'categories' => CategoryResource::collection($categories)
        ], 200);
    }

    private function oneCategory($id)
    {
        return Category::find($id);
    }
    private function notFoundResponse()
    {
        return response()->json([
            'status' => false,
            'message' => 'Category Not Found',
        ], 404);
    }

    public function show($id)
    {
        $category = $this->oneCategory($id);

        if (!$category) {
            return $this->notFoundResponse();
        }

        return response()->json([
            'status' => true,
            'category' => new CategoryResource($category)
        ], 200);
    }

    public function create(CategoryRequest $request)
    {

        $category = $this->categoryService->create($request->validated());  //service and validate in one row

        return response()->json([
            'status' => true,
            'message' => 'Category Created Successfully',
            'category' => new CategoryResource($category),
        ], 201);
    }

    public function update(CategoryRequest $request, $id)
    {

        $category = $this->oneCategory($id);

        if (!$category) {
            return $this->notFoundResponse();
        }

        $validated =  $request->validated();
        $category->update([
            'title' => $validated['title'],
        ]);

        return response()->json([
            'status' => true,
            'message' => "Category Updated Successfully",
            'category' => new CategoryResource($category)
        ], 200);
    }

    public function delete($id)
    {
        $category = $this->oneCategory($id);

        if (!$category) {
            return $this->notFoundResponse();
        }

        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category Deleted Successfully'
        ], 200);
    }
}
