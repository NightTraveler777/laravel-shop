<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::published()->with('category', 'user')
            ->orderBy('id', 'desc')
            ->paginate(2);
        return view('posts.index', compact('posts'));
    }

    public function show($slug) {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $post->views += 1;
        $post->update();

        $previous_post = Post::where('created_at', '<', $post->created_at)
            ->published()
            ->orderBy('created_at', 'DESC')
            ->first();

        $next_post = Post::where('created_at', '>', $post->created_at)
            ->published()
            ->orderBy('created_at', 'ASC')
            ->first();

        $comments = $post->comments()->with('user')
            ->published()
            ->orderBy('created_at', 'asc')
            ->paginate(2);

//        $view->with('cats', Category::withCount('posts')->orderBy('posts_count', 'desc')->get());

        return view('posts.show', compact('post', 'comments', 'previous_post', 'next_post'));
    }

    /**
     * Сохраняет новый комментарий в базу данных
     */
    public function comment(CommentRequest $request) {
        $request->merge(['user_id' => auth()->user()->id]);
        $message = 'Комментарий добавлен, будет доступен после проверки';
        if (auth()->user()->hasPermAnyWay('publish-comment')) {
            $request->merge(['published_by' => auth()->user()->id]);
            $message = 'Комментарий добавлен и уже доступен для просмотра';
        }
        $comment = Comment::create($request->all());
        // комментариев может быть много, поэтому есть пагинация; надо
        // перейти на последнюю страницу — новый комментарий будет там
        $page = $comment->post->comments()->published()->paginate()->lastPage();
        return redirect()
            ->route('posts.single', ['slug' => $comment->post->slug, 'page' => $page])
            ->withFragment('comment-form')
            ->with('success', $message);
    }
}
