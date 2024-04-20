<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandwidthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\PPPoEController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('bandwidth/queue', [BandwidthController::class, 'index'])->name('bandwidth.queue');
Route::post('bandwidth/queue/add', [BandwidthController::class, 'add'])->name('bandwidth.add');

//PPPOE
Route::get('pppoe/secret', [PPPoEController::class, 'index'])->name('pppoe.secret');
Route::post('pppoe/secret/add', [PPPoEController::class, 'add'])->name('pppoe.add');
Route::get('pppoe/secret/edit/{id}', [PPPoEController::class, 'edit'])->name('pppoe.edit');
Route::post('pppoe/secret/update', [PPPoEController::class, 'update'])->name('pppoe.update');
Route::get('pppoe/secret/delete/{id}', [PPPoEController::class, 'delete'])->name('pppoe.delete');

//Hotspot
Route::get('hotspot/secret', [HotspotController::class, 'index'])->name('hotspot.user');
Route::post('hotspot/secret/add', [HotspotController::class, 'add'])->name('hotspot.add');
Route::get('hotspot/secret/edit/{id}', [HotspotController::class, 'edit'])->name('hotspot.edit');
Route::post('hotspot/secret/update', [HotspotController::class, 'update'])->name('hotspot.update');
Route::get('hotspot/secret/delete/{id}', [HotspotController::class, 'delete'])->name('hotspot.delete');
