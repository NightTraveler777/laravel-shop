<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->published()->with('user')->orderBy('id', 'desc')->paginate(2);
        return view('categories.show', compact('category', 'posts'));
    }
}
