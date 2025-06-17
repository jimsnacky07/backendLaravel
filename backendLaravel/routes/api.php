<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TagihanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('penghuni', PenghuniController::class);
Route::apiResource('kamar', KamarController::class);
Route::apiResource('keuangan', KeuanganController::class);
Route::apiResource('admin', AdminController::class);
Route::apiResource('tagihan', TagihanController::class);
