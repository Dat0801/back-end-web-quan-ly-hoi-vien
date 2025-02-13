<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'token.expiration'])->group(function () {
    
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::prefix('documents')->group(function () {
        Route::get('/', [DocumentController::class, 'index']);
        Route::post('/', [DocumentController::class, 'store']);
        Route::delete('/{id}', [DocumentController::class, 'destroy']);
        Route::get('/download/{id}', [DocumentController::class, 'download']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [AccountController::class, 'index']); 
        Route::post('/', [AccountController::class, 'store']); 
        Route::get('/{account}', [AccountController::class, 'show']); 
        Route::put('/{account}', [AccountController::class, 'update']); 
        Route::delete('/{account}', [AccountController::class, 'destroy']); 
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']); 
        Route::get('/{id}', [RoleController::class, 'show']); 
        Route::put('/{id}', [RoleController::class, 'update']); 
        Route::delete('/{id}', [RoleController::class, 'destroy']); 
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

