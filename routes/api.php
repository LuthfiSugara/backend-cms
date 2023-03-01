<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth
Route::post('login', [Api\AuthController::class, 'login']);
Route::get('verify', [Api\AuthController::class, 'verify'])->name('api.verify');
Route::post('verify', [Api\AuthController::class, 'verify'])->name('api.verify');
Route::put('verify', [Api\AuthController::class, 'verify'])->name('api.verify');
Route::delete('verify', [Api\AuthController::class, 'verify'])->name('api.verify');

Route::group(['middleware' => ['auth:sanctum']], function(){
    // Auth
    Route::post('logout', [Api\AuthController::class, 'logout']);

    Route::group(['middleware' => ['role:admin']], function () {
        // User
        Route::get('user', [Api\UserController::class, 'index']);
        Route::post('user', [Api\UserController::class, 'store'])->name('api.user.create');
        Route::get('user/{id}', [Api\UserController::class, 'show']);
        Route::put('user', [Api\UserController::class, 'update']);
        Route::delete('user/{id}', [Api\UserController::class, 'destroy']);

        // Role
        Route::get('role', [Api\RoleController::class, 'index']);
        Route::post('role', [Api\RoleController::class, 'store']);
        Route::get('role/{id}', [Api\RoleController::class, 'show']);
        Route::put('role', [Api\RoleController::class, 'update']);
        Route::delete('role/{id}', [Api\RoleController::class, 'destroy']);

        // Category
        Route::get('category', [Api\CategoryController::class, 'index']);
        Route::post('category', [Api\CategoryController::class, 'store']);
        Route::get('category/{id}', [Api\CategoryController::class, 'show']);
        Route::put('category', [Api\CategoryController::class, 'update']);
        Route::delete('category/{id}', [Api\CategoryController::class, 'destroy']);
    });

    Route::group(['middleware' => ['role:admin|editor|user']], function () {
        // Post
        Route::get('post', [Api\PostController::class, 'index']);
        Route::post('post', [Api\PostController::class, 'store'])->name('api.post.create');;
        Route::get('post/{id}', [Api\PostController::class, 'show']);
        Route::put('post', [Api\PostController::class, 'update']);
        Route::delete('post/{id}', [Api\PostController::class, 'destroy']);
    });
});
