<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // Redirect to dashboard
    Route::get('/', fn () => redirect()->route('admin::dashboard'))->name('index');

    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // Posts
    Route::put('/posts/{post}/approval', 'PostController@approval')->name('posts.approval');
    Route::put('/posts/{post}/restore', 'PostController@restore')->name('posts.restore');
    Route::delete('/posts/{post}/kill', 'PostController@kill')->name('posts.kill');
    Route::resource('/posts', 'PostController');
    // Comments
    Route::put('/comments/{comment}/approve', 'PostCommentController@approve')->name('comments.approve');
    Route::delete('/comments/{comment}', 'PostCommentController@destroy')->name('comments.destroy');
    // Categories
    Route::resource('/categories', 'CategoryController')->except(['create', 'show']);
});
