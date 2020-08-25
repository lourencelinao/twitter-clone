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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tweets', 'TweetController@index')->name('tweets.index');
Route::get('/users', 'UserController@index')->name('users.store');
Route::get('/users/{user}', 'UserController@show')->name('users.store');

Route::post('/tweets', 'TweetController@store')->name('tweets.store');
Route::post('/follows', 'FollowController@store')->name('follows.store');
