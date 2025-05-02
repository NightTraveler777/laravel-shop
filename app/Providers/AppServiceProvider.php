<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Label;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('layouts.sidebar', function ($view) {
            $view->with('popular_posts', Post::published()->orderBy('views', 'desc')->limit(3)->get());
            $view->with('cats', Category::withCount('posts')->orderBy('posts_count', 'desc')->get());
            $view->with('tags', Tag::withCount('posts')->orderBy('posts_count', 'desc')->limit(5)->get());
        });

        view()->composer('layouts.shop-sidebar', function ($view) {
            $view->with('popular_albums', Album::orderBy('views', 'desc')->limit(3)->get());
            $view->with('gnrs', Genre::withCount('albums')->orderBy('albums_count', 'desc')->get());
            $view->with('tags', Tag::withCount('albums')->orderBy('albums_count', 'desc')->limit(5)->get());
        });

        view()->composer('layouts.header', function ($view) {
            $view->with('genres', Genre::withCount('albums')->orderBy('albums_count', 'desc')->get());
            $view->with('labels', Label::withCount('albums')->orderBy('albums_count', 'desc')->get());
        });

        view()->composer(['user.index', 'user.profile'], function ($view) {
            $view->with('active_profile', Profile::find(auth()->user()->profile_id));
            $view->with('types', ['Артист', 'Лейбл', 'Фанат']);
        });
    }
}
