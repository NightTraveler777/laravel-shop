<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $albums = Album::with('genre', 'label')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $posts = Post::published()
            ->with('category', 'user')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->paginate(4);

        return view('home', compact('albums', 'posts'));
    }
}
