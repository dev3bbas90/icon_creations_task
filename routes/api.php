<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login'        , [LoginController::class, 'login']   )->middleware('CheckMaxAllowedLoggedDevices');
    Route::post('logout'       , [LoginController::class, 'logout']  );
    // Route::post('refresh'   , [LoginController::class, 'refresh'] );
    // Route::post('me'        , [LoginController::class, 'me']      );

});
