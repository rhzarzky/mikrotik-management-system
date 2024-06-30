<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\DashboardRouterController;

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

//auth login
Route::get('/session', [AuthController::class, 'index'])->name('showSession');

Route::middleware(['auth'])->get('/login-user', function () {
    $user = auth()->user();

    $firstname = $user->userData ? $user->userData->firstname : $user->username;
    $lastname = $user->userData ? $user->userData->lastname : null;
    $organization = $user->userData ? $user->userData->organization : null;
    $address = $user->userData ? $user->userData->address : null;
    $photo = $user->userData ? $user->userData->photo : null;

    return response()->json([
        'username' => $user->username,
        'email' => $user->email,
        'role' => $user->role,
        'user_data' => [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'organization' => $organization,
            'address' => $address,
            'photo' => $photo
        ],
    ]);
})->name('login');
Route::post('/login-user', [AuthController::class, 'loginUser']);

Route::post('/login-router', [AuthController::class, 'loginRouter']);
Route::middleware(['auth'])->get('/login-router', function () {
    return response()->json([
        'address' => session('address'),
        'username' => session('username'),
        'password' => session('password'),
    ]);
})->name('loginRouter');
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/logout-router', [AuthController::class, 'logoutRouter']);

//user
Route::get('/user-show', [UserController::class, 'index'])->middleware('auth');
Route::post('/user-store', [UserController::class, 'store']);
Route::put('/user-update/{id}', [UserController::class, 'update']);
Route::delete('/user-destroy/{id}', [UserController::class, 'destroy']);

//router
Route::get('/router-show', [RouterController::class, 'index'])->middleware('auth');
Route::post('/router-store', [RouterController::class, 'store']);
Route::put('/router-update/{id}', [RouterController::class, 'update']);
Route::delete('/router-destroy/{id}', [RouterController::class, 'destroy']);

//dashboard-router
Route::get('/interface-show', [DashboardRouterController::class, 'interface']);

Route::get('{any?}', function() {
    return view('application');
})->where('any', '.*');
