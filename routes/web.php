<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'users' , 'as' => 'users.' , 'middleware' => 'auth'], function () {
    Route::get('/'                , [UserController::class, 'index'])     ->name('index');
    Route::get('activate/{id}'    , [UserController::class, 'activate'])  ->name('activate');
    Route::get('block/{id}'       , [UserController::class, 'block'])     ->name('block');
});
