<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('home');
})->name('home');*/

Route::get('/', 'HomeController@index')->name('home.index');

Route::get('/blog', 'PostController@index')->name('posts.list');
Route::get('/blog/post/{slug}', 'PostController@show')->name('posts.single');
Route::get('/blog/category/{slug}', 'CategoryController@show')->name('categories.single');
Route::get('/blog/tag/{slug}', 'TagController@show')->name('tags.single');
Route::get('/blog/author/{user}', 'AuthorController@show')->name('author.single');
Route::get('/blog/search', 'SearchController@index')->name('blog.search');
Route::post('/blog/post/{post}/comment', 'PostController@comment')->name('blog.comment');

Route::get('/shop', 'ShopController@index')->name('shop.index');
Route::get('/shop/genre/{slug}', 'ShopController@genre')->name('shop.genre');
Route::get('/shop/label/{slug}', 'ShopController@label')->name('shop.label');
Route::get('/shop/artist/{slug}', 'ShopController@artist')->name('shop.artist');
Route::get('/shop/tag/{slug}', 'ShopController@tag')->name('shop.tag');
Route::get('/shop/album/{slug}', 'ShopController@album')->name('shop.album');
Route::get('/shop/search', 'ShopController@search')->name('shop.search');

Route::get('/basket/index', 'BasketController@index')->name('basket.index');
Route::get('/basket/checkout', 'BasketController@checkout')->name('basket.checkout');
Route::post('/basket/add/{id}', 'BasketController@add')
    ->where('id', '[0-9]+')
    ->name('basket.add');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'role:root,admin'], function () {
    Route::get('/', 'MainController@index')->name('admin.index');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/tags', 'TagController');
    Route::resource('/posts', 'PostController');

    Route::resource('/albums', 'AlbumController');
    Route::resource('/genres', 'GenreController');
    Route::resource('/labels', 'LabelController');
    Route::resource('/artists', 'ArtistController');
    Route::post('/albums/ajax_store', 'AlbumController@ajax_store');
    Route::post('/albums/ajax_update', 'AlbumController@ajax_update');

    // доп.маршрут для показа постов категории
    Route::get('posts/category/{category}', 'PostController@category')->name('posts.category');
    // доп.маршрут, чтобы разрешить публикацию поста
    Route::put('posts/enable/{post}', 'PostController@enable')->name('posts.enable');
    // доп.маршрут, чтобы запретить публикацию поста
    Route::put('posts/disable/{post}', 'PostController@disable')->name('posts.disable');

    /*
     * Просмотр и редактирование пользователей
     */
    Route::resource('users', 'UserController', ['except' => ['store', 'show', 'destroy']]);

    /*
     * CRUD-операции над комментариями
     */
    Route::resource('comments', 'CommentController', ['except' => ['create', 'store']]);
    // доп.маршрут, чтобы разрешить публикацию комментария
    Route::put('comments/enable/{comment}', 'CommentController@enable')
        ->name('comments.enable');
    // доп.маршрут, чтобы запретить публикацию комментария
    Route::put('comments/disable/{comment}', 'CommentController@disable')
        ->name('comments.disable');

    /*
     * CRUD-операции над ролями
     */
    Route::resource('role', 'RoleController', ['except' => 'show']);
});

/*Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', 'UserController@create')->name('register.create');
    Route::post('/register', 'UserController@store')->name('register.store');
    Route::get('/login', 'UserController@loginForm')->name('login.create');
    Route::post('/login', 'UserController@login')->name('login');
});*/

Route::group(['as' => 'auth.', 'prefix' => 'auth'], function () {
    // форма регистрации
//    Route::get('register', 'Auth\RegisterController@register')->name('register');
    // создание пользователя
//    Route::post('register', 'Auth\RegisterController@create')->name('create');
    // форма входа
    Route::get('login', 'Auth\LoginController@login')->name('login');
    // аутентификация
    Route::post('login', 'Auth\LoginController@authenticate')->name('auth');
    // выход
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    // форма ввода адреса почты
    Route::get('forgot-password', 'Auth\ForgotPasswordController@form')->name('forgot-form');
    // письмо на почту
    Route::post('forgot-password', 'Auth\ForgotPasswordController@mail')->name('forgot-mail');
    // форма восстановления пароля
    Route::get(
        'reset-password/token/{token}/email/{email}',
        'Auth\ResetPasswordController@form'
    )->name('reset-form');
    // восстановление пароля
    Route::post('reset-password', 'Auth\ResetPasswordController@reset')->name('reset-password');
    // сообщение о необходимости проверки адреса почты
    Route::get('verify-message', 'Auth\VerifyEmailController@message')->name('verify-message');
    // подтверждение адреса почты нового пользователя
    Route::get('verify-email/token/{token}/id/{id}', 'Auth\VerifyEmailController@verify')
        ->where('token', '[a-f0-9]{32}')
        ->where('id', '[0-9]+')
        ->name('verify-email');
});

/*Route::get('/logout', 'UserController@logout')->name('logout')->middleware('auth');*/

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => 'auth'], function () {
    /*
     * Главная страница личного кабинета
     */
    Route::get('index', 'IndexController')->name('index');

    // Управление профилями
    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::put('profile/switch/{type}', 'ProfileController@switch')->name('profile.switch');

    /*
     * CRUD-операции над постами пользователя
     */
    Route::resource('post', 'PostController');
    /*
     * CRUD-операции над комментариями пользователя
     */
    Route::resource('comment', 'CommentController', ['except' => [
        'create', 'store'
    ]]);
    /*
     * CRUD-операции над альбомами пользователя
     */
    Route::resource('album', 'AlbumController');

    Route::post('ajax', 'AlbumController@ajax');
});

//Route::post('editor/image_upload', 'EditorController@upload')->name('upload');


