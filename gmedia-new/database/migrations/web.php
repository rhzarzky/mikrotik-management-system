<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::get('{any?}', function() {
    return view('application');
})->where('any', '.*');

//auth login
Route::post('/login-user', [AuthController::class, 'loginUser']);
Route::post('/login-router', [AuthController::class, 'loginRouter']);
Route::post('/logout', [AuthController::class, 'logout']);

//user
Route::get('/user-show', [UserController::class, 'index']);
Route::post('/user-store', [UserController::class, 'store']);
Route::post('/user-update', [UserController::class, 'update']);
Route::post('/user-destroy', [UserController::class, 'destroy']);
