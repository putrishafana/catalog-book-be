<?php
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\PublisherController;
use App\Http\Controllers\API\BookController;

use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);

    
});
Route::apiResource('author', AuthorController::class);
    Route::apiResource('publisher', PublisherController::class);
    Route::apiResource('book', BookController::class);