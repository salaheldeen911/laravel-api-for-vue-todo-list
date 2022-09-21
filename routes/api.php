<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Middleware\TodoMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/check', [AuthController::class, "check"]);

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);

Route::group(["middleware" => ['auth:sanctum', 'TodoMiddleware']], function () {
    Route::post('/logout', [AuthController::class, "logout"]);

    Route::group(["middleware" => 'TodoMiddleware'], function () {
        Route::apiResource('todos', TodoController::class)->except(['show']);
        Route::post('todos/done/{todo}', [TodoController::class, "done"]);
        Route::post('todos/delete-all', [TodoController::class, "deleteAll"]);
    });
});
