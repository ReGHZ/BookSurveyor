<?php

use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', function () {
        return view('welcome');
    })->name('home');
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('admin-page', function () {
        return view('admin.dashboard');
    })->middleware('role:admin');

    Route::get('user-page', function () {
        return view('user.dashboard');
    })->middleware('role:user');

    Route::get('/admin-page', [App\Http\Controllers\BookController::class, 'indexAdmin'])->middleware('role:admin')->name('admin.page');
    Route::get('/user-page', [App\Http\Controllers\BookController::class, 'indexUser'])->middleware('role:user')->name('user.page');
    Route::get('/get-book', [App\Http\Controllers\BookController::class, 'getBookUser'])->middleware('role:user')->name('getBook');
    Route::post('/store-book', [App\Http\Controllers\BookController::class, 'storeBook'])->middleware('role:user')->name('storeBook');
    Route::get('/edit-book/{id}', [App\Http\Controllers\BookController::class, 'editBookUser'])->middleware('role:user')->name('editBook');
    Route::put('/update-book/{id}', [App\Http\Controllers\BookController::class, 'updateBookUser'])->middleware('role:user')->name('updateBook');
    Route::delete('/delete-book/{id}', [App\Http\Controllers\BookController::class, 'deleteBookUser'])->middleware('role:user')->name('deleteBook');
    Route::put('/survey-book', [App\Http\Controllers\BookController::class, 'surveyBook'])->middleware('role:user')->name('surveyBook');

    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

Auth::routes();
