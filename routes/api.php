<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('authentication')->group(function() {
    Route::post('signup', [AuthenticationController::class, 'signUp']);
    Route::post('signin', [AuthenticationController::class, 'signIn']);
});