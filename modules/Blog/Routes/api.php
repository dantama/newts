<?php

use Illuminate\Support\Facades\Route;

// Search country states
Route::get('/load-project/{template}', 'ProjectController@show')->name('load-project');
Route::patch('/store-project/{template}', 'ProjectController@update')->name('store-project');
