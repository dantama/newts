<?php

// Redirect

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('account::home'))->name('index');

// Auth page
Route::middleware('auth')->group(function () {

	// Home
	Route::view('/home', 'account::home')->name('home');

	// User page
	Route::name('user.')->namespace('User')->group(function () {
		// Account
		Route::view('/profile', 'account::user.profile')->name('profile');
		Route::put('/profile', 'ProfileController@update')->name('profile');

		// Avatar
		Route::view('/avatar', 'account::user.avatar')->name('avatar');
		Route::put('/avatar', 'AvatarController@update')->name('avatar');

		// Password
		Route::view('/password', 'account::user.password')->name('password');
		Route::put('/password', 'PasswordController@update')->name('password');
		Route::post('/password/reset', 'PasswordController@reset')->name('password.reset');
	});

	// Notifications
	Route::view('/notifications', 'account::notifications')->name('notifications');
	Route::get('/notifications/read-all', 'NotificationController@readAll')->name('notifications.read-all');
	Route::get('/notifications/{id}', 'NotificationController@read')->name('notifications.read');
});

// Verifying email, without authentication middleware
// Route::get('/email/verify', 'User\EmailController@verify')->name('user.email.verify');
