<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'published_by',
        'content',
    ];

    /**
     * Количество комментриев на странице при пагинации
     */
    protected $perPage = 5;

    /**
     * Связь модели Comment с моделью Post, позволяет получить
     * пост, которому принадлежит комментарий
     */
    public function post() {
        return $this->belongsTo(Post::class);
    }

    /**
     * Связь модели Comment с моделью Auth, позволяет получить
     * пользователя, который оставил комментарий
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь модели Comment с моделью Auth, позволяет получить
     * пользователя (админа), который разрешил комментарий
     */
    public function editor() {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Разрешить публикацию комментария к посту
     */
    public function enable() {
        $this->published_by = auth()->user()->id;
        $this->update();
    }

    /**
     * Запретить публикацию коментария к посту
     */
    public function disable() {
        $this->published_by = null;
        $this->update();
    }

    /**
     * Выбирать из БД только опубликованные комментарии
     */
    public function scopePublished($builder) {
        return $builder->whereNotNull('published_by');
    }

    /**
     * Номер последней страницы пагинации
     */
    public function lastPage($published = true) {
        $builder = $this->post->comments();
        if ($published) {
            $page = $builder->published()->paginate()->lastPage();
        } else {
            $page = $builder->paginate()->lastPage();
        }
        return $page;
    }

    /**
     * Номер страницы пагинации, на которой расположен комментарий;
     * учитываются все комментарии, в том числе не опубликованные
     */
    public function adminPageNumber($comments) {
        if (!$comments) {
            $comments = $this->post->comments()->orderBy('created_at')->get();
        }
        if ($comments->count() == 0) {
            return 1;
        }
        if ($comments->count() <= $this->getPerPage()) {
            return 1;
        }
        foreach ($comments as $i => $comment) {
            if ($this->id == $comment->id) {
                break;
            }
        }
        return (int) ceil(($i+1) / $this->getPerPage());
    }

    /**
     * Возвращает true, если публикация разрешена
     */
    public function isVisible() {
        return ! is_null($this->published_by);
    }

    /**
     * Возвращает true, если пользователь является автором
     */
    public function isAuthor() {
        return $this->user->id === auth()->user()->id;
    }

    /**
     * Номер страницы пагинации, на которой расположен комментарий;
     * все опубликованные + не опубликованные этого пользователя
     */
    public function userPageNumber($comments) {
        // все опубликованные комментарии других пользователей
        $others = $this->post->comments()->published();
        // и не опубликованные комментарии этого пользователя
        $comments = $this->post->comments()
            ->whereUserId(auth()->user()->id)
            ->whereNull('published_by')
            ->union($others)
            ->orderBy('created_at')
            ->get();
        if ($comments->count() == 0) {
            return 1;
        }
        if ($comments->count() <= $this->getPerPage()) {
            return 1;
        }
        foreach ($comments as $i => $comment) {
            if ($this->id == $comment->id) {
                break;
            }
        }
        return (int) ceil(($i+1) / $this->getPerPage());
    }
}
