<?php

use Illuminate\Support\Facades\Route;

Route::prefix('qr')->group(function () {
    Route::get('/', [App\Http\Controllers\QrCodeController::class, 'index']);
    Route::get('/show/{id}', [App\Http\Controllers\QrCodeController::class,'show']);
    Route::post('/create', [App\Http\Controllers\QrCodeController::class,'store']);
    Route::put('/update', [App\Http\Controllers\QrCodeController::class, 'update']);
    Route::delete('/delete', [App\Http\Controllers\QrCodeController::class, 'destroy']);
});
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
