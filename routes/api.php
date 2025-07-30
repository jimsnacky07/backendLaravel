<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PenghuniController;
use App\Http\Controllers\Api\KamarController;
use App\Http\Controllers\Api\KeuanganController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\TagihanController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
// Auth routes
Route::post('/admin/register', [AuthController::class, 'register']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/tagihan/{user_id}/edit', [TagihanController::class, 'editTagihan']);
Route::middleware('auth:sanctum')->get('/admin/dashboard', [AuthController::class, 'dashboard']);
Route::get('/penghuni/user/{user_id}', [PenghuniController::class, 'byUserId']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Tambahkan route ini di routes/api.php
Route::post('/user/change-password', [App\Http\Controllers\Api\UserController::class, 'changePassword'])
    ->middleware('auth:sanctum');

Route::apiResource('penghuni', PenghuniController::class);
Route::apiResource('kamar', KamarController::class);
Route::apiResource('keuangan', KeuanganController::class);
Route::apiResource('admin', AdminController::class);
Route::apiResource('tagihan', TagihanController::class);
Route::apiResource('user', UserController::class);
Route::post('login', [UserController::class, 'login']);
