<?php

use Illuminate\Support\Facades\Route;

// Search country states
Route::get('/search-districs', 'StatesController@searchDistricByRegency')->name('search-districs');

// Search country states
Route::get('/country-states/search', 'CountryStateController@search')->name('country-states.search');

// Get phones
Route::get('/phones/index', 'PhoneController@index')->name('phones.index');

// Get user
Route::get('/users/search', 'UserController@index')->name('user.search');

// Payment notification
Route::post('/payment/notification', 'PaymentController@getNotification')->name('payment.notification');

Route::middleware('api')->group(function () {
    Route::get('/members', 'MemberController@index')->name('members.index');
    Route::get('/unit/position', 'UnitController@position')->name('unit.position');
    Route::post('/testimony/images-upload', 'FilepondController@store')->name('testimony.images-upload');
    Route::post('/blog/images-upload', 'BlogImageController@store')->name('blog.images-upload');
});
