<?php 
use App\Http\Controllers\Api\JWTAuthController;
use App\Http\Controllers\Api\TaskController;

Route::middleware(['auth:api','throttle:api','middleware' => 'api','prefix' => 'auth'])->group(function () {
    Route::apiResource('tasks2', TaskController::class);
});

Route::post('/login', [JWTAuthController::class, 'login']);
Route::post('/logout', [JWTAuthController::class, 'logout']);