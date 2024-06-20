<?php

use Illuminate\Support\Facades\Route;

// Search country states
Route::get('/search-districs', 'StatesController@searchDistricByRegency')->name('search-districs');
