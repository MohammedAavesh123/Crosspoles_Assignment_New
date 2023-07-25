<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/get-users', [App\Http\Controllers\HomeController::class, 'index'])->name('get-users.index');
Route::any('/add-users', [App\Http\Controllers\HomeController::class, 'store'])->name('users.create');

Route::any('admin/fetch-states', [App\Http\Controllers\HomeController::class, 'fetchState'])->name('fetch-states');
Route::any('admin/fetch-cities', [App\Http\Controllers\HomeController::class, 'fetchCity'])->name('fetch-cities');
