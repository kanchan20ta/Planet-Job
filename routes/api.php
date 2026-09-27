<?php

use App\Http\Controllers\Api\ApplicationApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\JobApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (v1) — Sanctum token auth for mobile apps / SPA clients
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::post('login', [AuthApiController::class, 'login']);

    // Public, read-only job data
    Route::get('jobs', [JobApiController::class, 'index']);
    Route::get('jobs/{job}', [JobApiController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthApiController::class, 'logout']);

        Route::get('applications', [ApplicationApiController::class, 'index']);
        Route::post('jobs/{job}/apply', [ApplicationApiController::class, 'store']);

        Route::get('user', fn (\Illuminate\Http\Request $request) => $request->user());
    });
});
