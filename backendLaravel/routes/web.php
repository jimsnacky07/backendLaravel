<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;

// Login routes (tidak pakai middleware)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.process');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Register routes (jika ingin tetap bisa register tanpa login)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.process');

// Semua route lain WAJIB login
Route::get('/', [DashboardController::class, 'index']);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('admin', AdminController::class);
Route::resource('kamar', KamarController::class);
Route::resource('keuangan', KeuanganController::class);
Route::resource('penghuni', PenghuniController::class);
Route::resource('tagihan', TagihanController::class);
Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
