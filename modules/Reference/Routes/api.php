<?php

use Illuminate\Support\Facades\Route;

// Search country states
Route::get('/search-districs', 'StatesController@searchDistricByRegency')->name('search-districs');

Route::middleware('api')->group(function () {
    Route::get('/members', 'MemberController@index')->name('members.index');
    Route::get('/unit/position', 'UnitController@position')->name('unit.position');
});
