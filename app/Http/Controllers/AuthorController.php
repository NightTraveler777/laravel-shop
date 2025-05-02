<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($user) {
        $user = User::where('id', $user)->firstOrFail();
        $posts = $user->posts()->published()->with('category')->orderBy('id', 'desc')->paginate(2);
        return view('author.show', compact('user', 'posts'));
    }
}
