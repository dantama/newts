<?php

use Illuminate\Support\Facades\Route;
use Modules\Administration\Http\Middleware\AdminableMiddleware;
use Modules\Administration\Http\Middleware\ManagerMiddleware;

Route::middleware(['auth', AdminableMiddleware::class, ManagerMiddleware::class])->group(function () {
    // Redirect to dashboard
    Route::get('/', fn () => redirect()->route('admin::dashboard'))->name('index');
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // unit group
    Route::namespace('Unit')->group(function () {
        // unit
        Route::get('units/{unit}', 'UnitController@index')->name('units.index');
        // Unit departement
        Route::resource('units.departements', 'UnitDepartementController')->parameters(['departement' => 'departement']);
        // Unit position
        Route::resource('units.positions', 'UnitPositionController')->parameters(['positions' => 'position']);
    });

    Route::namespace('Manager')->group(function () {
        // Managers
        Route::resource('managers', 'ManagerController');
    });

    Route::namespace('Member')->group(function () {
        // Members
        Route::resource('members', 'MemberController');
        // Student
        Route::resource('students', 'StudentController');
    });
});
