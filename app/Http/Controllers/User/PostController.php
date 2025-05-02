<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware('perm:create-post')->only(['create', 'store']);
    }

    /**
     * Список всех постов пользователя
     */
    public function index() {
        $posts = Post::whereUserId(auth()->user()->id)->orderByDesc('created_at')->paginate();
        return view('user.posts.index', compact('posts'));
    }

    /**
     * Показывает форму создания поста
     */
    public function create() {
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view('user.posts.create', compact('categories', 'tags'));
    }

    /**
     * Сохраняет новый пост в базу данных
     */
    public function store(Request $request) {
        /*$request->merge(['user_id' => auth()->user()->id]);
        $post = Post::create($request->all());
        $post->tags()->attach($request->tags);
        return redirect()
            ->route('user.post.show', ['post' => $post->id])
            ->with('success', 'Новый пост успешно создан');*/

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        $data = $request->all();
        $data['thumbnail'] = Post::uploadImage($request);

        $post = Post::create($data);
        $post->tags()->sync($request->tags);

        $this->notify($post);

        return redirect()->route('user.post.show', ['post' => $post->id])->with('success', 'Статья добавлена');
    }

    /**
     * Отправляет письмо админу о создании нового поста
     */
    private function notify(Post $post) {
        $admin = User::find(1);

        Mail::send(
            'email.new-post',
            ['post' => $post],
            function ($message) use ($admin) {
                $message->to($admin->email);
//                $message->cc('info@recordsman.ru');
                $message->subject('Новый пост блога');
            }
        );
    }

    /**
     * Страница пред.просмотра поста блога
     */
    public function show(Post $post) {
        // можно просматривать только свои посты
        if (!$post->isAuthor()) {
            abort(404);
        }
        // сигнализирует о том, что это режим пред.просмотра
        session()->flash('preview', 'yes');
        // все опубликованные комментарии других пользователей
        $others = $post->comments()->published();
        // и не опубликованные комментарии этого пользователя
        $comments = $post->comments()
            ->whereUserId(auth()->user()->id)
            ->whereNull('published_by')
            ->union($others)
            ->orderBy('created_at')
            ->paginate();
        return view('user.posts.show', compact('post', 'comments'));
    }

    /**
     * Показывает форму редактирования поста
     */
    public function edit(Post $post) {
        // редактировать можно только свои посты
        if (!$post->isAuthor()) {
            abort(404);
        }
        // редактировать можно не опубликованные
        if ($post->isVisible()) {
            abort(404);
        }
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        // нужно сохранить flash-переменную, которая сигнализирует о том,
        // что кнопка редактирования была нажата в режиме пред.просмотра
        session()->keep('preview');
        return view('user.posts.edit', compact('post', 'categories', 'tags' ));
    }

    /**
     * Обновляет пост блога в базе данных
     */
    public function update(Request $request, Post $post) {
        // обновлять можно только свои посты
        if (!$post->isAuthor()) {
            abort(404);
        }
        // обновлять можно не опубликованные
        if ($post->isVisible()) {
            abort(404);
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);

        $data = $request->all();

        if ($file = Post::uploadImage($request, $post->thumbnail)) {
            $data['thumbnail'] = $file;
        }

        $post->update($data);
        $post->tags()->sync($request->tags);

        $route = 'user.post.index';
        $param = [];
        if (session('preview')) {
//            $route = 'user.post.show';
            $route = 'posts.show';
            $param = ['post' => $post->id];
        }
        return redirect()->route($route, $param)->with('success', 'Изменения сохранены');
    }

    /**
     * Удаляет пост блога из базы данных
     */
    public function destroy(Post $post) {
        // удалять можно только свои посты
        if (!$post->isAuthor()) {
            abort(404);
        }
        // удалять можно не опубликованные
        if ($post->isVisible()) {
            abort(404);
        }
        $post->delete();
        return redirect()
            ->route('user.post.index')
            ->with('success', 'Пост блога успешно удален');
    }
}
