<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $response = Post::findAllWithoutTrashedByCategory($category);

        return view('pages.web.category.category', compact('category', 'response'));
    }
}
