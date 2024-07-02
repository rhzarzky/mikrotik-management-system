<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardRouterController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserHotspotController;

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
        'id' => session('id'),
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
Route::post('/change-password', [UserController::class, 'changePassword']);

//user data
Route::get('/userdata-show', [UserDataController::class, 'index'])->middleware('auth');
Route::post('/userdata-store-update', [UserDataController::class, 'storeOrUpdate']);
Route::put('/userdata-store-update', [UserDataController::class, 'storeOrUpdate']);

//router
Route::get('/router-show', [RouterController::class, 'index'])->middleware('auth');
Route::post('/router-store', [RouterController::class, 'store']);
Route::put('/router-update/{id}', [RouterController::class, 'update']);
Route::delete('/router-destroy/{id}', [RouterController::class, 'destroy']);

//dashboard-user
Route::get('/dashboard-stats', [DashboardController::class, 'getStats']);

//dashboard-router
Route::get('/interface-show', [DashboardRouterController::class, 'interface']);

//user-profile
Route::get('/user-profile-show', [UserProfileController::class, 'index'])->middleware('auth');
Route::post('/user-profile-store', [UserProfileController::class, 'store']);
Route::put('/user-profile-update/{id}', [UserProfileController::class, 'update']);
Route::delete('/user-profile-destroy/{id}', [UserProfileController::class, 'destroy']);

//user-hotspot
Route::get('/user-hotspot-show', [UserHotspotController::class, 'index'])->middleware('auth');
Route::post('/user-hotspot-store', [UserHotspotController::class, 'store']);
Route::put('/user-hotspot-update/{id}', [UserHotspotController::class, 'update']);
Route::delete('/user-hotspot-destroy/{id}', [UserHotspotController::class, 'destroy']);
Route::put('/user-activation/{id}', [UserHotspotController::class, 'activation']);
Route::get('/user-active-show', [UserHotspotController::class, 'active'])->middleware('auth');


Route::get('{any?}', function() {
    return view('application');
})->where('any', '.*');
