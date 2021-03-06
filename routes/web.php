<?php


namespace Router;

use App\Comment;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Support\Facades\Auth;
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


Route::get('/','HomeController@home')->name('home');
Route::get('contact','HomeController@contact')->name('contact');


Route::get('secret','HomeController@secret')
    ->name('secret')
    ->middleware('can:home.secret');


Route::resource('/posts','PostController');

Route::get('/posts/tag/{tag}','PostTagController@index')->name('posts.tags.index');

Route::resource('posts.comments','PostCommentController')->only(['index','store']);
Route::resource('users.comments','UserCommentController')->only(['store']);
Route::resource('users','UserController')->only(['show','edit','update']);


Route::get('mailable',function(){
    $comment = Comment::first();
    return new CommentPostedMarkdown($comment);
});

Auth::routes();
