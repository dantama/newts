<?php

use Illuminate\Support\Facades\Route;

// Search country states
Route::get('/evaluator/parents', 'EvaluatorController@searchParent')->name('evaluator.parents');
