<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request) {
        $new_posts = Post::whereNull('published_by')->orderBy('created_at')
            ->with('user')
            ->limit(5)->get();
        $all_comments = Comment::orderBy('created_at')
            ->with('user', 'post', 'post.comments')
            ->get();
        $new_comments = $all_comments->whereNull('published_by');

        return view('admin.index', compact('new_posts', 'new_comments'));
    }
}
