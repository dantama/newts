<?php

use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Middleware\IsAdminMiddleware;

Route::middleware(['auth', IsAdminMiddleware::class])->group(function () {

	Route::redirect('/', '/home')->name('index');
	// Home
	Route::get('/home', 'Controller@index')->name('home');

	// Submissions
	Route::get('/submissions', 'SubmissionController@index')->name('submissions.index');
	Route::post('/submissions', 'SubmissionController@store')->name('submissions.store');
	Route::delete('/submissions/{event}', 'SubmissionController@destroy')->name('submissions.delete');

	// Register
	Route::get('/register/{event}', 'RegisterController@register')->name('register.index');
	Route::post('/register/{event}', 'RegisterController@store')->name('register.store');
	Route::post('/register/{refid}/payment', 'RegisterController@payment')->name('register.payment');
	Route::put('/register/{event}/{refid}', 'RegisterController@pass')->name('register.pass');
	Route::delete('/register/{event}/{refid}', 'RegisterController@delete')->name('register.delete');

	// Manage
	Route::name('manage.')->prefix('manage')->namespace('Manage')->group(function () {

		Route::get('center/{event}/print', 'CenterController@printEvent')->name('center.print');
		Route::get('/center/{member}/card', 'CenterController@card')->name('center.card');
		Route::resource('center', 'CenterController', ['names' => 'center'])->parameters(['center' => 'event']);
		Route::put('center/{event}/restore', 'CenterController@restore')->name('center.restore');
		Route::put('center/{event}/approve', 'CenterController@approve')->name('center.approve');
		Route::delete('center/{event}/kill', 'CenterController@kill')->name('center.kill');

		// Print Event
		Route::get('province/{event}/print', 'ProvinceController@printEvent')->name('province.print');
		Route::get('/province/{member}/card', 'ProvinceController@card')->name('province.card');
		Route::resource('province', 'ProvinceController', ['names' => 'province'])->parameters(['province' => 'event']);
		Route::put('province/{event}/restore', 'ProvinceController@restore')->name('province.restore');
		Route::put('province/{event}/approve', 'ProvinceController@approve')->name('province.approve');
		Route::delete('province/{event}/kill', 'ProvinceController@kill')->name('province.kill');

		// Print Event
		Route::get('regency/{event}/print', 'RegencyController@printEvent')->name('regency.print');

		Route::resource('regency', 'RegencyController', ['names' => 'regency'])->parameters(['regency' => 'event']);
		Route::put('regency/{event}/restore', 'RegencyController@restore')->name('regency.restore');
		Route::put('regency/{event}/approve', 'RegencyController@approve')->name('regency.approve');
		Route::delete('regency/{event}/kill', 'RegencyController@kill')->name('regency.kill');

		Route::resource('category', 'CategoryController', ['names' => 'category'])->parameters(['category' => 'category']);
	});
});
