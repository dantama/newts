<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'web::index')->name('index');

Route::redirect('/pesan', 'https://forms.gle/8oUGq1SBVH6LXfGq8');
