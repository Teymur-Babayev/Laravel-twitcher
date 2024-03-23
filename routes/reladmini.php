<?php

use Crivion\Reladmini\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::group(['prefix' => config('reladmini.path'), 'middleware' => ['web']], function() {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('reladmini.dashboard');

});