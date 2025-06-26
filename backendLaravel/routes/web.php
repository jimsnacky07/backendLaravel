<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', [DashboardController::class, 'index']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Endpoint login admin
Route::post('admin/login', [AdminController::class, 'login']);
// Admin CRUD (web)
Route::resource('admin', AdminController::class);
// Kamar CRUD (web)
Route::resource('kamar', KamarController::class);
// Keuangan CRUD (web)
Route::resource('keuangan', KeuanganController::class);
// Penghuni CRUD (web)
Route::resource('penghuni', PenghuniController::class);
// Tagihan CRUD (web)
Route::resource('tagihan', TagihanController::class);

// Login routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.process');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Laporan
Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
