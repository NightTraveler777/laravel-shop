<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Список всех комментариев пользователя
     */
    public function index() {
        $comments = Comment::whereUserId(auth()->user()->id)
            ->orderByDesc('created_at')
            ->with('user', 'post', 'post.comments')
            ->paginate();
        return view('user.comments.index', compact('comments'));
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
        // можно просматривать только свои комментарии
        if ( ! $comment->isAuthor()) {
            abort(404);
        }
        // сигнализирует о том, что это режим пред.просмотра
        session()->flash('preview', 'yes');
        // это тот пост блога, к которому оставлен комментарий
        $post = $comment->post;
        // все опубликованные комментарии других пользователей
        $others = $post->comments()->published();
        // и не опубликованные комментарии этого пользователя
        $comments = $post->comments()
            ->whereUserId(auth()->user()->id)
            ->whereNull('published_by')
            ->union($others)
            ->orderBy('created_at')
            ->paginate();
        // используем шаблон предварительного просмотра поста
        return view('user.posts.show', compact('post', 'comments'));
    }

    /**
     * Показывает форму редактирования комментария
     */
    public function edit(Comment $comment) {
        // проверяем права пользователя на это действие
        if ( ! $this->can($comment)) {
            abort(404);
        }
        // нужно сохранить flash-переменную, которая сигнализирует о том,
        // что кнопка редактирования была нажата в режиме пред.просмотра
        session()->keep('preview');
        return view('user.comments.edit', compact('comment'));
    }

    /**
     * Обновляет комментарий в базе данных
     */
    public function update(CommentRequest $request, Comment $comment) {
        // проверяем права пользователя на это действие
        if (!$this->can($comment)) {
            abort(404);
        }
        $comment->update($request->all());
        return $this->redirectAfterUpdate($comment);
    }

    /**
     * Удаляет комментарий из базы данных
     */
    public function destroy(Comment $comment) {
        // проверяем права пользователя на это действие
        if ( ! $this->can($comment)) {
            abort(404);
        }
        $comment->delete();
        // кнопка удаления может быть нажата в режиме пред.просмотра
        // или в личном кабинете пользователя, поэтому редирект разный
        $route = 'user.comment.index';
        if (session('preview')) {
            $route = 'user.comment.index';
        }
        return redirect()->route($route)->with('success', 'Комментарий успешно удален');
    }

    /**
     * Выполняет редирект после обновления
     */
    private function redirectAfterUpdate(Comment $comment) {
        // кнопка редактирования может быть нажата в режиме пред.просмотра
        // или в личном кабинете пользователя, поэтому и редирект разный
        $redirect = redirect();
        if (session('preview')) {
            $redirect = $redirect->route(
                'user.comment.show',
                ['comment' => $comment->id, 'page' => $comment->userPageNumber(null)]
            )->withFragment('comment-area');
        } else {
            $redirect = $redirect->route('user.comment.index');
        }
        return $redirect->with('success', 'Комментарий был успешно исправлен');
    }

    /**
     * Проверяет, что пользователь может редактировать
     * или удалять пост блога
     */
    private function can(Comment $comment) {
        return $comment->isAuthor() && !$comment->isVisible();
    }
}
