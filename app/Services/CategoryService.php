<?php

namespace App\Services;

use App\Models\Category;

class CategoryService{
    public function index(){
        $categories = Category::get();
        return $categories;
    }

     public function create($data)
    {

        $category = Category::create([
            'title' => $data['title']
        ]);

        return $category;
    }

}
