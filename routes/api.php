<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployeController;

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

// Public routes - Authentication
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes - Require JWT authentication
Route::middleware(['auth:api'])->group(function () {
    
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Department routes
    Route::prefix('departements')->group(function () {
        // All authenticated users can view
        Route::get('/', [DepartementController::class, 'index']);
        Route::get('/{id}', [DepartementController::class, 'show']);
        
        // Only RH and ADMIN can create/update
        Route::middleware(['role:RH,ADMIN'])->group(function () {
            Route::post('/', [DepartementController::class, 'store']);
            Route::put('/{id}', [DepartementController::class, 'update']);
        });
        
        // Only ADMIN can delete
        Route::middleware(['role:ADMIN'])->group(function () {
            Route::delete('/{id}', [DepartementController::class, 'destroy']);
        });
    });

    // Employee routes
    Route::prefix('employes')->group(function () {
        // All authenticated users can view
        Route::get('/', [EmployeController::class, 'index']);
        Route::get('/{id}', [EmployeController::class, 'show']);
        
        // Only RH and ADMIN can create/update/delete
        Route::middleware(['role:RH,ADMIN'])->group(function () {
            Route::post('/', [EmployeController::class, 'store']);
            Route::put('/{id}', [EmployeController::class, 'update']);
            Route::delete('/{id}', [EmployeController::class, 'destroy']);
        });
    });
});
