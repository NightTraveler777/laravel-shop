<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug) {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->published()->with('category')->with('user')->orderBy('id', 'desc')->paginate(2);
        return view('tags.show', compact('tag', 'posts'));
    }
}
