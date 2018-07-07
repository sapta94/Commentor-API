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
    return view('welcome');
});

// List articles
//Route::get('users', 'UserController@index');

// Login User
Route::post('users/login', 'UserController@store');

// Current User
// Route::get('current/user', 'UserController@fetch');

// // Register User
// Route::post('users/register', 'UserController@register');

// // Create Comment
// Route::post('comment', 'CommentsController@store');

// // Get Comment
// Route::get('comment/{id}', 'CommentsController@show');

// // Get all Comments
// Route::get('comment', 'CommentsController@index');

// // Update Comments
// Route::post('comment/update', 'CommentsController@update');


// // Delete article
// Route::delete('comment/{id}', 'CommentsController@destroy');

// //Logout
// Route::get('/logout','UserController@logout');
