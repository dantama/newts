<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WebController@index')->name('index');

Route::view('/member', 'web::member')->name('member');
