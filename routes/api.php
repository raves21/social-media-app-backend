<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//auth protected
Route::middleware('auth:sanctum')->group(function () {

    //users
    Route::controller(UserController::class)->prefix('users')->group(function () {

        //all users
        Route::get('/', 'index');

        //current user
        Route::prefix('me')->group(function () {
            //current user info
            Route::get('/', [UserController::class, 'me']);
            //posts of the current user
            Route::get('posts', [PostController::class, 'getCurrentUserPosts']);
        });

        //user
        Route::prefix('{id}')->group(function () {
            //user info
            Route::get('/', [UserController::class, 'show']);
            //posts of a user
            Route::get('posts', [PostController::class, 'getUserPosts']);
        });
    });

    //posts
    Route::apiResource('posts', PostController::class);

    //post comments
    Route::prefix('posts/{postId}')->group(function () {
        Route::apiResource('comments', CommentController::class);
    });

    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

//auth unprotected
Route::post('/register', [AuthController::class, 'register']);
