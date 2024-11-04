<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\AuthenticationController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('roles')->group(function () {
            Route::get('/', [App\Http\Controllers\UserRolesController::class, 'index']);
            Route::get('/show', [App\Http\Controllers\UserRolesController::class, 'show']);
            Route::post('/create', [App\Http\Controllers\UserRolesController::class, 'store']);
            Route::put('/update', [App\Http\Controllers\UserRolesController::class, 'update']);
            Route::delete('/delete', [App\Http\Controllers\UserRolesController::class, 'destroy']);
        });
    });
});
