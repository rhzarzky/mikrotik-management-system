<?php

use App\Http\controllers\AuthController;
use App\Http\controllers\DashboardController;
use App\Http\controllers\HostpotController;
use App\Http\Controllers\UserController;
use App\Http\controllers\RouterController;
use App\Http\controllers\TransaksiController;
use App\Http\controllers\TrafficController;
use App\Http\controllers\LandingController;
use App\Http\controllers\PemesananController;
use App\Http\Controllers\InterfaceController;
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

//login
Route::get('/', [AuthController::class, 'Index'])->name('landing-page.index');
Route::get('login', [AuthController::class, 'Index'])->name('login');
Route::get('loginAuth', [AuthController::class, 'loginAuth'])->name('loginAuth');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('logoutUser', [AuthController::class, 'logoutUser'])->name('logoutUser');

//dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard/cpu', [DashboardController::class, 'cpu'])->name('dashboard.cpu');

// Realtime
Route::get('dashboard/load', [DashboardController::class, 'load'])->name('dashboard.load');
Route::get('dashboard/uptime', [DashboardController::class, 'uptime'])->name('dashboard.uptime');
Route::get('dashboard/{traffic}', [DashboardController::class, 'traffic'])->name('dashboard.traffic');
Route::get('dashboard-special/{traffic}', [DashboardController::class, 'traffic_special'])->name('dashboard.traffic-special');

// Check Traffic Interface
Route::get('/interface', [InterfaceController::class, 'interface'])->name('interface');

//hotspot-voucher
Route::get('/hotspot/voucher', [HostpotController::class, 'voucher'])->name('voucher');
Route::post('/hotspot/voucher', [HostpotController::class, 'addvoucher'])->name('addvoucher.post');
Route::post('/hotspot/voucher/generate', [HostpotController::class, 'generatevoucher'])->name('generatevoucher.post');
Route::post('/hotspot/voucher/update', [HostpotController::class, 'updatevoucher'])->name('updatevoucher.post');
Route::get('/hotspot/voucher/delete/{id}', [HostpotController::class, 'deletevoucher'])->name('deletevoucher');
Route::get('/hotspot/voucher/print/{id}', [HostpotController::class, 'printvoucher'])->name('printvoucher');
Route::post('/hotspot/voucher/save', [HostpotController::class, 'save'])->name('save.post');

//hotspot-profile
Route::get('/hotspot/profile', [HostpotController::class, 'profile'])->name('profile');
Route::post('/hotspot/profile/add', [HostpotController::class, 'addprofile'])->name('addprofile.post');
Route::post('/hotspot/profile/update', [HostpotController::class, 'updateprofile'])->name('updateprofile.post');
Route::get('/hotspot/profile/delete/{id}', [HostpotController::class, 'deleteprofile'])->name('deleteprofile');

//Hotspot-active
Route::get('/hotspot/status', [HostpotController::class, 'active'])->name('active');
Route::get('/hotspot/status/active', [HostpotController::class, 'time'])->name('active.time');

//Hotspot-scheduler
Route::get('/hotspot/scheduler', [HostpotController::class, 'scheduler'])->name('scheduler');

//User
Route::get('user', [UserController::class, 'user'])->name('user');
Route::post('user', [UserController::class, 'adduser'])->name('adduser.post');
Route::post('/user/edit/{id}', [UserController::class, 'ubah'])->name('user.edit');
Route::get('/user/delete/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
Route::post('/user/update-password/{id}', [UserController::class, 'updatePassword'])->name('updatePassword');

//Router
Route::get('router', [RouterController::class, 'router'])->name('router');
Route::post('router', [RouterController::class, 'addrouter'])->name('addrouter.post');
Route::post('/router/edit/{id}', [RouterController::class, 'ubah'])->name('router.edit');
Route::get('/router/delete/{id}', [RouterController::class, 'deleteRouter'])->name('deleteRouter');
