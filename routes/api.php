<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'user'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
});

Route::middleware('auth:api')->group(function() {
    Route::group(['prefix' => 'user'], function () {
        Route::post('me', [UserController::class, 'me']);
        Route::post('logout', [UserController::class, 'logout']);
        Route::post('refresh', [UserController::class, 'refresh']);
    });
    Route::apiResource('boards', BoardController::class);
    Route::apiResource('boards.tasks', TaskController::class);
});

