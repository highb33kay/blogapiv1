<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Index: Get all posts
    Route::get('posts', [PostController::class, 'index']);

    // Show: Get a specific post
    Route::get('posts/{id}', [PostController::class, 'show']);

    // Store: Create a new post
    Route::post('posts', [PostController::class, 'store']);

    // Update: Update a specific post
    Route::put('posts/{id}', [PostController::class, 'update']);

    // Destroy: Delete a specific post
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
});

// Register: Register a new user
Route::post('register', [AuthController::class, 'register']);

// Login: Login an existing user
Route::post('login', [AuthController::class, 'login']);

// Logout: Logout an existing user
Route::post('logout', [AuthController::class, 'logout']);

// get an authenticated user
Route::get('user', [AuthController::class, 'user']);


