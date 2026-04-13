<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'Categories' => CategoryResource::collection($categories)
        ], 200);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'category' => new CategoryResource($category)
        ], 200);
    }

    public function create(CategoryRequest $request)
    {
        $request->validated();
        $category = Category::create([
            'title' => $request->title
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'Category Created Successfully',
            'category' => new CategoryResource($category),
        ], 201);
    }

    public function Update(CategoryRequest $request, $id)
    {
        $request->validated();

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found'
            ], 404);
        }

        $category->Update([
            'title' => $request->title,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Category Updated Successfully",
            'Category' => new CategoryResource($category)
        ], 200);
    }

    public function delete($id){
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found'
            ], 404);
        }

        $category->delete();
        return response()->json([
                'status' => true,
                'message' => 'Category Deleted Successfully '
            ], 200);

    }
}
