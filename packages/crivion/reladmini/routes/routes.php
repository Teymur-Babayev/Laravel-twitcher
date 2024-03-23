<?php

use Illuminate\Support\Facades\Route;

use Crivion\Reladmini\Http\Controllers\DashboardController;
use Crivion\Reladmini\Http\Controllers\ProfileController;

Route::group(['prefix' => config('reladmini.path'), 'middleware' => ['web']], function() {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('reladmini.dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('reladmini.profile');

});