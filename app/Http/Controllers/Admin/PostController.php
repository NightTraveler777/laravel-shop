<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-posts')->only(['index', 'category', 'show']);
        $this->middleware('perm:edit-post')->only(['edit', 'update']);
        $this->middleware('perm:publish-post')->only(['enable', 'disable']);
        $this->middleware('perm:delete-post')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category', 'tags', 'user', 'editor')->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Список постов категории блога
     */
    public function category(Category $category) {
        $posts = $category->posts()->with(['tags', 'user', 'editor'])->paginate(20);
        return view('admin.posts.category', compact('category', 'posts'));
    }

    /**
     * Страница просмотра поста блога
     */
    public function show(Post $post) {
        // сигнализирует о том, что это режим пред.просмотра
        session()->flash('preview', 'yes');
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Разрешить публикацию поста блога
     */
    public function enable(Post $post) {
        $post->enable();
        return back()->with('success', 'Пост блога был опубликован');
    }

    /**
     * Запретить публикацию поста блога
     */
    public function disable(Post $post) {
        $post->disable();
        return back()->with('success', 'Пост блога снят с публикации');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return redirect()->route('posts.index')->with('success', 'Статья добавлена');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();

        // нужно сохранить flash-переменную, которая сигнализирует о том,
        // что кнопка редактирования была нажата в режиме пред.просмотра
        session()->keep('preview');

        return view('admin.posts.edit', compact('categories', 'tags', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);

        $post = Post::find($id);
        $data = $request->all();

        if ($file = Post::uploadImage($request, $post->thumbnail)) {
            $data['thumbnail'] = $file;
        }

        $post->update($data);
        $post->tags()->sync($request->tags);

        $route = 'posts.index';
        $param = [];
        if (session('preview')) {
            $route = 'posts.show';
            $param = ['post' => $post->id];
        }
        return redirect()->route($route, $param)->with('success', 'Изменения сохранены');

//        return redirect()->route('posts.index')->with('success', 'Изменения сохранены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->sync([]);
        Storage::delete($post->thumbnail);
        $post->delete();

        // пост может быть удален в режиме пред.просмотра или из панели
        // управления, так что и редирект после удаления будет разным
        $route = 'posts.index';
        if (session('preview')) {
            $route = 'posts.list';
        }
        return redirect()->route($route)->with('success', 'Статья удалена');

//        return redirect()->route('posts.index')->with('success', 'Статья удалена');
    }
}
