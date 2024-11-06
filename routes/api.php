<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\AuthenticationController::class, 'login']);
});

Route::prefix('members')->group(function (){
    Route::get('/', [App\Http\Controllers\Membership\MembershipController::class, 'index']);
    Route::get('/show', [App\Http\Controllers\Membership\MembershipController::class, 'show']);
    Route::post('/create', [App\Http\Controllers\Membership\MembershipController::class, 'store']);
    Route::put('/update', [App\Http\Controllers\Membership\MembershipController::class, 'update']);
    Route::delete('/delete', [App\Http\Controllers\Membership\MembershipController::class, 'destroy']);
});

Route::prefix('roles')->group(function () {
    Route::get('/', [App\Http\Controllers\UserRolesController::class, 'index']);
    Route::get('/show', [App\Http\Controllers\UserRolesController::class, 'show']);
    Route::post('/create', [App\Http\Controllers\UserRolesController::class, 'store']);
    Route::put('/update', [App\Http\Controllers\UserRolesController::class, 'update']);
    Route::delete('/delete', [App\Http\Controllers\UserRolesController::class, 'destroy']);
});

Route::prefix('users')->group(function() {
    Route::get('/', [App\Http\Controllers\UsersController::class, 'index']);
    Route::get('/show', [App\Http\Controllers\UsersController::class,'show']);
    Route::post('/create', [App\Http\Controllers\UsersController::class, 'store']);
    Route::put('/update', [App\Http\Controllers\UsersController::class, 'update']);
    Route::delete('/delete', [App\Http\Controllers\UsersController::class, 'destroy']);
});

Route::prefix('reservations')->group(function() {
    Route::get('/', [App\Http\Controllers\FlightReservationController::class, 'index']);
    Route::get('/show', [App\Http\Controllers\FlightReservationController::class,'show']);
    Route::post('/create', [App\Http\Controllers\FlightReservationController::class,'store']);
    Route::put('/update', [App\Http\Controllers\FlightReservationController::class, 'update']);
    Route::delete('/delete', [App\Http\Controllers\FlightReservationController::class, 'destroy']);
});

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::prefix('v1')->group(function () {

//     });
// });
