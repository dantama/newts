<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WebController@index')->name('index');
Route::get('/{category}/{slug}', 'WebController@read')->name('read');

Route::view('/member', 'web::member')->name('member');
Route::view('/profile', 'web::profile')->name('profile');
Route::view('/blogs', 'web::blog')->name('blogs');
Route::view('/events', 'web::event')->name('events');
