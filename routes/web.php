<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/user/{name}', [App\Http\Controllers\UserController::class, 'show']);

Route::view('/about', 'pages.about')->name('about');

Route::redirect('/log-in', '/login');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'app'], function () {
        Route::get('/dashboard', App\Http\Controllers\DashboardController::class)->name('dashboard');
         Route::resource('/tasks', TaskController::class);
    }); 

    Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function () {
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class);
        Route::get('/stats', App\Http\Controllers\Admin\StatsController::class);
    }); 

}); 

// One more task is in routes/api.php
require __DIR__.'/auth.php';
