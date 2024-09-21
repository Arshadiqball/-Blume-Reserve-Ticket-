<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BRTController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('brts', [BRTController::class, 'index']);
    Route::post('brts', [BRTController::class, 'store']);
    Route::get('brts/{id}', [BRTController::class, 'show']);
    Route::put('brts/{id}', [BRTController::class, 'update']);
    Route::delete('brts/{id}', [BRTController::class, 'destroy']);
});