<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
// Route::view('/home', 'layouts.app');
Route::redirect('/home', '/dashboard');

Auth::routes();

Route::group([
    'middleware' => ['auth'],
], function () {
    Route::view('/{any?}', 'layouts.app')->name('dashboard')->where('any', '.*');
});
