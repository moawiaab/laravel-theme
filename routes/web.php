<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::view('/home', 'layouts.app');

Route::group([
    'middleware' => ['guest'],
], function () {

    Route::redirect('/', '/login');
});

Auth::routes();

Route::group([
    'middleware' => ['auth'],
], function () {
    Route::redirect('/home', '/dashboard');
    Route::redirect('/', '/dashboard');

    Route::view('/{any?}', 'layouts.app')->name('dashboard')->where('any', '.*');
    // Route::view('/{any?}', 'layouts.app')->name('dashboard')->where('any', '.*');
});
