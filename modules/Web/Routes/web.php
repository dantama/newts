<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WebController@index')->name('index');
Route::get('/{category}/{slug}', 'WebController@read')->name('read');
Route::get('/blogs', 'WebController@blog')->name('blogs');

Route::view('/member', 'web::member')->name('member');
Route::view('/profile', 'web::profile')->name('profile');
Route::view('/events', 'web::event')->name('events');
