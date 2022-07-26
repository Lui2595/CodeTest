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

use App\Blogs;

Route::get('/', function () {
    $posts= Blogs::orderBy('created_at','desc')->paginate(5);
    //return $posts;
    return view('welcome',compact('posts')); 
});
Route::get('/posts/{id}', function ($id) {

   $post= Blogs::find($id);
    if($post && $post->status=='Published'){
        return view('post',compact('post'));
    }
    else{
        abort(404);
    }
    //return $posts;
})->name("post");

Auth::routes();

Route::prefix('admin')->middleware('auth','admin')->group(function () {
    Route::get('/', 'AdminController@get')->name("admin.dash");
    Route::put('/', 'AdminController@put');
    Route::get('/users', 'AdminController@get_users')->name("admin.users");
    Route::post('/users', 'AdminController@add_user');
    Route::delete('/users', 'AdminController@delete_user')->name("admin.usersDelete");
    Route::put('/users', 'AdminController@update_user')->name("admin.usersUpdate");
    Route::post('/users/sup', 'AdminController@add_sup')->name("admin.bloggerSup");
    Route::get('/blogs', 'AdminController@get_blogs')->name("admin.blogs");
    Route::post('/blogs', 'AdminController@add_blogs')->name("admin.blogsAdd");
    Route::put('/blogs', 'AdminController@update_blogs')->name("admin.blogsUpdate");
    Route::delete('/blogs', 'AdminController@delete_post')->name("admin.blogsDelete");
    Route::get('/supervisors', 'AdminController@get_supervisors')->name("admin.supervisors");

});     
Route::prefix('supervisor')->middleware('auth','supervisor')->group(function () {
    Route::get('/', 'SupervisorController@get')->name("sup.dash");
    Route::put('/', 'SupervisorController@put');

    Route::get('/blogs', 'SupervisorController@get_blogs')->name("sup.blogs");
    Route::post('/blogs', 'SupervisorController@add_blogs')->name("sup.blogsAdd");
    Route::put('/blogs', 'SupervisorController@update_blogs')->name("sup.blogsUpdate");
    Route::delete('/blogs', 'SupervisorController@delete_post')->name("sup.blogsDelete");

    Route::get('/users', 'SupervisorController@get_users')->name("sup.users");

});
Route::prefix('blogger')->middleware('auth','blogger')->group(function () {
    Route::get('/', 'BloggerController@get')->name("blogger.dash");
    Route::put('/', 'BloggerController@put');
    Route::get('/blogs', 'BloggerController@get_blogs')->name("blogger.blogs");
    Route::post('/blogs', 'BloggerController@add_blogs')->name("blogger.blogsAdd");
    Route::put('/blogs', 'BloggerController@update_blogs')->name("blogger.blogsUpdate");
    Route::delete('/blogs', 'BloggerController@delete_post')->name("blogger.blogsDelete");
});
