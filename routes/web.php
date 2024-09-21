<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BRTAnalyticsController;

Route::get('/admin/analytics/total', [BRTAnalyticsController::class, 'getTotalAnalytics']);
Route::get('/admin/analytics/trends', [BRTAnalyticsController::class, 'getTrendsAnalytics']);


Route::get('/', function () {
    return view('dashboard');
});

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF token set']);
});