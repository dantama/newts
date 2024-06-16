<?php

use Illuminate\Support\Facades\Route;

Route::get('/employees/search', 'EmployeeController@search')->name('employees.search');
