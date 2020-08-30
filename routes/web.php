<?php

use Illuminate\Support\Facades\Redirect;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/return', function(){
    return back(302);
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tweets', 'TweetController@index')->name('tweets.index');
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/users/{user}', 'UserController@show')->name('users.store');
Route::get('/users/{user}/tweet/{tweet}', 'TweetController@show')->name('tweet.show');
Route::get('/tweets/{tweet}/comments/create', 'CommentController@homeComment')->name('comments.homeComment');
Route::get('/users/{user}/following', 'UserController@following')->name('users.following');
Route::get('/users/{user}/followers', 'UserController@followers')->name('users.followers');

Route::post('/tweets', 'TweetController@store')->name('tweets.store');
Route::post('/follows', 'FollowController@store')->name('follows.store');
Route::post('/likes', 'LikeController@store')->name('likes.store');
Route::post('/retweets', 'RetweetController@store')->name('retweets.store');

Route::patch('/users/{user}', 'UserController@update')->name('users.update');

Route::delete('/likes/delete', 'LikeController@destroy')->name('likes.delete');
Route::delete('/follows/delete', 'FollowController@destroy')->name('follows.delete');
Route::delete('/tweets/{tweet}', 'TweetController@destroy')->name('tweets.delete');
Route::delete('/retweets/{retweet}', 'RetweetController@destroy')->name('retweets.delete');