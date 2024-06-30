<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // Redirect to dashboard
    Route::get('/', fn () => redirect()->route('core::dashboard'))->name('index');

    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // Administration
    Route::prefix('administration')->namespace('Administration')->name('administration.')->group(function () {
        // Units
        Route::get('units/export', 'UnitController@export')->name('units.export');
        Route::resource('units', 'UnitController');
        // Unit departement
        Route::resource('unit-departements', 'UnitDepartementController')->parameters(['unit_departements' => 'unit_departement']);

        // Unit position
        Route::resource('unit-positions', 'UnitPositionController')->parameters(['unit_positions' => 'unit_position']);

        // Managers
        Route::resource('managers', 'ManagerController');
    });

    // Membership
    Route::prefix('membership')->namespace('Membership')->name('membership.')->group(function () {
        // Member
        Route::post('members/import', 'MemberController@importMember')->name('members.import');
        Route::resource('members', 'MemberController');
    });

    // System
    Route::prefix('system')->namespace('System')->name('system.')->group(function () {
        // Departments
        Route::resource('departments', 'DepartmentsController');

        // Positions
        Route::resource('positions', 'PositionController');

        // Role references
        Route::put('roles.restore', 'RoleController@restore')->name('roles.restore');
        Route::put('roles/{role}/permissions', 'RoleController@permissions')->name('roles.permissions');
        Route::resource('roles', 'RoleController')->except('edit', 'create');

        // Users
        Route::put('users/{user}/restore', 'UserController@restore')->name('users.restore');
        Route::put('users/{user}/repass', 'UserController@repass')->name('users.repass');
        Route::put('users/{user}/roles', 'UserController@roles')->name('users.roles');
        Route::put('users/{user}/profile', 'User\ProfileController@update')->name('users.update.profile');
        Route::post('users/{user}/login', 'UserController@login')->name('users.login');
        Route::resource('users', 'UserController')->except(['create', 'edit', 'update']);

        // User logs
        Route::resource('user-logs', 'UserLogController')->parameters(['user-logs' => 'log'])->only('index', 'destroy');
    });
});
