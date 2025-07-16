<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PenghuniController;
use App\Http\Controllers\Api\KamarController;
use App\Http\Controllers\Api\KeuanganController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\TagihanController;
use App\Http\Controllers\Api\AuthController;
// Auth routes
Route::post('/admin/register', [AuthController::class, 'register']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/admin/dashboard', [AuthController::class, 'dashboard']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('penghuni', PenghuniController::class);
Route::apiResource('kamar', KamarController::class);
Route::apiResource('keuangan', KeuanganController::class);
Route::apiResource('admin', AdminController::class);
Route::apiResource('tagihan', TagihanController::class);
