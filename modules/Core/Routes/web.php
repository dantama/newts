<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // Redirect to dashboard
    Route::get('/', fn () => redirect()->route('admin::dashboard'))->name('index');

    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('membership')->namespace('Membership')->name('membership.')->group(function () {
        // Membership
        Route::resource('members', 'MemberController');
        Route::resource('certificates', 'CertificateController');
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
