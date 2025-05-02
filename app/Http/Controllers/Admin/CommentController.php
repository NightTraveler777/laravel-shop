<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-comments')->only(['index', 'show']);
        $this->middleware('perm:edit-comment')->only('update');
        $this->middleware('perm:publish-comment')->only(['enable', 'disable']);
        $this->middleware('perm:delete-comment')->only('destroy');
    }

    /**
     * Показывает список всех комментариев
     */
    public function index() {
        $comments = Comment::orderBy('id', 'asc')
            ->with('user', 'post', 'editor', 'post.comments')
            ->paginate(5);
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Просмотр комментария к посту блога
     */
    public function show(Comment $comment) {
        // сигнализирует о том, что это режим пред.просмотра
        session()->flash('preview', 'yes');
        // это тот пост блога, к которому оставлен комментарий
        $post = $comment->post;
        // коллекция всех комментариев к этому посту блога
        $comments = $post->comments()->orderBy('created_at')->paginate(2);
        // используем шаблон предварительного просмотра поста
        return view('admin.posts.show', compact('post', 'comments'));
    }

    /**
     * Показывает форму редактирования комментария
     */
    public function edit(Comment $comment) {
        // нужно сохранить flash-переменную, которая сигнализирует о том,
        // что кнопка редактирования была нажата в режиме пред.просмотра
        session()->keep('preview');
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Обновляет комментарий в базе данных
     */
    public function update(CommentRequest $request, Comment $comment) {
        $comment->update($request->all());
        return $this->redirectAfterUpdate($comment);
    }

    /**
     * Разрешить публикацию комментария
     */
    public function enable(Comment $comment) {
        $comment->enable();
        $redirect = back();
        if (session('preview')) {
            $redirect = $redirect->withFragment('comment-area');
        }
        return $redirect->with('success', 'Комментарий был опубликован');
    }

    /**
     * Запретить публикацию комментария
     */
    public function disable(Comment $comment) {
        $comment->disable();
        $redirect = back();
        if (session('preview')) {
            $redirect = $redirect->withFragment('comment-area');
        }
        return $redirect->with('success', 'Комментарий снят с публикации');
    }

    /**
     * Удаляет комментарий из базы данных
     */
    public function destroy(Comment $comment) {
        $comment->delete();
        $route = 'comments.index';
        if (session('preview')) {
            $route = 'comments.index';
        }
        return redirect()->route($route)->with('success', 'Комментарий успешно удален');
    }

    /**
     * Выполянет редирект после обновления
     */
    private function redirectAfterUpdate(Comment $comment) {
        // кнопка редактирования может быть нажата в режиме пред.просмотра
        // или в панели управления блогом, поэтому и редирект будет разный
        $redirect = redirect();
        if (session('preview')) {
            $redirect = $redirect->route(
                'comments.show',
                ['comment' => $comment->id, 'page' => $comment->adminPageNumber(null)]
            )->withFragment('comment-area');
        } else {
            $redirect = $redirect->route('comments.index');
        }
        return $redirect->with('success', 'Комментарий был успешно исправлен');
    }
}
