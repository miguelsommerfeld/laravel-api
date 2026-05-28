<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DonationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('authentication')->group(function() {
    Route::post('signup', [AuthenticationController::class, 'signUp']);
    Route::post('signin', [AuthenticationController::class, 'signIn']);
});

Route::prefix('donation')->group(function() {
    Route::post('/', [DonationController::class, 'donate']);

    Route::prefix('back_url')->group(function() {
        Route::get('success', fn () => true);
        Route::get('failure', fn () => false);
    }); 
});