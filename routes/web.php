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

Route::redirect('/','/home');

Route::get('/profile/{profile}', 'ProfileController@show');
Route::patch('/profile/{profile}', 'ProfileController@update');

Route::post('/like/to/{article}', 'ArticleController@like');
Route::post('/unlike/to/{article}', 'ArticleController@unlike');

Route::patch('/rate/article/{article}', 'ArticleController@updateRating');

Route::delete('/unrate/article/{article}', 'ArticleController@deleteRating');

Route::post('/save/to/{article}', 'ArticleController@save');
Route::post('/unsave/to/{article}', 'ArticleController@unsave');

Route::post('/{article}/comments', 'ArticleController@showComments');
Route::post('/{article}/store/comment', 'ArticleController@saveComment');

Route::get('/articles/{article}/stats', 'ArticleController@displayStats');
Route::get('/articles/create', 'ArticleController@create');
Route::get('/articles/show/{article}', 'ArticleController@show');
Route::get('/articles/{category?}', 'ArticleController@index');
Route::get('/articles/search/{q}', 'ArticleController@search');

Route::resource('articles', 'ArticleController')->except(['index','create','show']);



Route::post('/like/to/comment/{comment}', 'CommentController@like');
Route::post('/unlike/to/comment/{comment}', 'CommentController@unlike');

Route::post('/{comment}/replies', 'CommentController@showReplies');

Route::post('/{comment}/store/reply', 'CommentController@saveReply');

Route::resource('comments', 'CommentController')->only(['update','destroy']);

Route::post('/like/to/reply/{reply}', 'CommentController@likeReply');
Route::post('/unlike/to/reply/{reply}', 'CommentController@unlikeReply');
Route::get('/comment/{comment}/stats', 'CommentController@displayStats');


Route::resource('replies', 'ReplyController')->only(['update','destroy']);
Route::get('/reply/{reply}/stats', 'ReplyController@displayStats');


Route::patch('/notifications/read', 'NotificationController@read');
Route::delete('/notifications/{id}', 'NotificationController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



