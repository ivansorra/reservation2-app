<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\AuthenticationController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {

});
