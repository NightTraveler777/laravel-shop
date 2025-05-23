<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profiles() {
        return $this->hasMany(Profile::class);
    }

    /**
     * Связь модели Auth с моделью Post, позволяет получить все
     * посты пользователя
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * Связь модели Auth с моделью Comment, позволяет получить все
     * комментарии пользователя
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function switch_profile($profile_id) {
        $this->profile_id = $profile_id;
        $this->update();
    }
}
