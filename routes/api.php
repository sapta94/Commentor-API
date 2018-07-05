<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List articles
Route::get('users', 'UserController@index');

// Login User
Route::post('users/login', 'UserController@store');

// Register User
Route::post('users/register', 'UserController@register');

// Create Comment
Route::post('comment', 'CommentsController@store');

// Get Comment
Route::get('comment/{id}', 'CommentsController@show');

// Get all Comments
Route::get('comment', 'CommentsController@index');

// Update Comments
Route::put('comment', 'CommentsController@update');


// Delete article
Route::delete('comment/{id}', 'CommentsController@destroy');

