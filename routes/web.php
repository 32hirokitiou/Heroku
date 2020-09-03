<?php

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

Route::get('/', function () {
    return redirect('/register');
});

Auth::routes();
/*
|--------------------------------------------------------------------------
| 1) User 認証不要
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:user'], function () {
    // Route::get('/home', 'HomeController@index')->name('home');
    // Route::get('/home', 'HomeController@index')->name('home');

    // Route::get('/welcome', function () {
    //     return redirect('posts/index');
    // });
    //

    Route::get('favorite', 'FavoriteController@index');
    //お気に入り表示画面
    Route::get('user/show', 'UserController@show');
    Route::get('user/edit', 'UserController@edit');
    Route::post('user/edit', 'UserController@update');
    //ユーザー画像の追加分
    Route::get('/user', 'UserController@index')->name('user.index');
    Route::get('/user/userEdit', 'UserController@userEdit')->name('user.userEdit');
    Route::post('/user/userEdit', 'UserController@userUpdate')->name('user.userUpdate');
    //ユーザー画像の追加分
    Route::get('user/userShow', 'UserController@userShow'); //ユーザープロフィールからそのユーザーの投稿一覧に飛ぶ
    //indexから個人プロフィールへの遷移
    Route::get('user/{id}', 'UserController@show');
    //indexから個人プロフィールへの遷移

    //ユーザーテンプレテスト
    Route::get('child', 'UserController@test');
    Route::get('common', 'UserController@common');
    //ユーザーテンプレ

    //ユーザー画像の追加分
    Route::get('posts/add', 'PostsController@add');
    Route::post('posts/create', 'PostsController@create');
    Route::get('posts/index', 'PostsController@index'); // 追記
    Route::get('posts/edit', 'PostsController@edit');
    Route::post('posts/edit', 'PostsController@update');
    Route::get('posts/delete', 'PostsController@delete');
    Route::get('posts/show', 'PostsController@show');
    //詳細表示画面
    Route::get('posts/{id}', 'PostsController@showDetail')->name('show');

    //facvariteの確認
    Route::group(['prefix' => 'posts/{id}'], function () {
        Route::post('favorite', 'FavoriteController@store')->name('favorites.favorite');
        Route::delete('unfavorite', 'FavoriteController@destroy')->name('favorites.unfavorite');
    });

    //Tag一覧検索用
    Route::get('tags/index', 'TagsController@index');
    Route::get('tags/show', 'TagsController@show');
});



/*
|--------------------------------------------------------------------------
| 3) Admin 認証不要
|--------------------------------------------------------------------------
*/
// Route::group(['prefix' => 'admin'], function () {
//     Route::get('/',         function () {
//         return redirect('/admin/home');
//     });
//     Route::get('login',     'Admin\LoginController@showLoginForm')->name('admin.login');
//     Route::post('login',    'Admin\LoginController@login');
// });

// // /*
// // |--------------------------------------------------------------------------
// // | 4) Admin ログイン後
// // |--------------------------------------------------------------------------
// // */
// Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
//     Route::post('logout',   'Admin\LoginController@logout')->name('admin.logout');
//     Route::get('home',      'Admin\HomeController@index')->name('admin.home');
// });
