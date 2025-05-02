<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'description', 'content', 'user_id', 'category_id', 'thumbnail'];

    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь модели Post с моделью User, позволяет получить
     * администратора, который разрешил публикацию поста
     */
    public function editor() {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Связь модели Post с моделью Comment, позволяет получить
     * все комментарии к посту
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * Разрешить публикацию поста блога
     */
    public function enable() {
        $this->published_by = auth()->user()->id;
        $this->update();
    }

    /**
     * Запретить публикацию поста блога
     */
    public function disable() {
        $this->published_by = null;
        $this->update();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function uploadImage(Request $request, $image = null) {
        if ($request->hasFile('thumbnail')) {
            if ($image) {
                Storage::delete($image);
            }
            $folder = date('Y-m-d');
            return $request->file('thumbnail')->store("images/{$folder}");
        }
        return null;
    }

    public function getImage() {
        if (!$this->thumbnail) {
            return asset('no-img.png');
        }
        return asset("storage/{$this->thumbnail}");
    }

    public function getPostDate() {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
    }

    public function scopeLike($query, $s) {
        return $query->where('title', 'LIKE', "%{$s}%");
    }

    /**
     * Возвращает true, если публикация разрешена
     */
    public function isVisible() {
        return ! is_null($this->published_by);
    }

    /**
     * Выбирать из БД только опубликованные посты
     */
    public function scopePublished($builder) {
        return $builder->whereNotNull('published_by');
    }

    /**
     * Возвращает true, если пользователь является автором
     */
    public function isAuthor() {
        return $this->user->id === auth()->user()->id;
    }
}
