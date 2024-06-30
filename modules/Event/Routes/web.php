<?php

use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Middleware\IsAdminMiddleware;

Route::middleware(['auth', IsAdminMiddleware::class])->group(function () {

	Route::redirect('/', '/home')->name('index');
	// Home
	Route::get('/home', 'DashboardController@index')->name('home');

	// Manage
	Route::name('manage.')->prefix('manage')->namespace('Manage')->group(function () {
		// events
		Route::resource('events', 'EventController');
		// category
		Route::resource('categories', 'CategoryController');
	});

	Route::name('finance.')->prefix('finance')->namespace('Finance')->group(function () {
		// cart
		Route::resource('carts', 'CartController');
		// invoice
		Route::resource('invoices', 'InvoiceController');
		// payment
		Route::resource('payments', 'PaymentController');
	});
});
