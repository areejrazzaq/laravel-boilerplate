<?php

use App\Http\Controllers\API\ResourceController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['api','json.response','logger'])->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::middleware(['auth:api', 'json.response','logger'])->group(function () {
    // protected routes
    Route::resource('mock', ResourceController::class);

    Route::middleware(['role:admin|moderator'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
    Route::middleware(['role:admin'])->group(function () {
    });
    Route::middleware(['role:moderator'])->group(function () {
    });
});

Route::fallback(function () {
    return response('API Resource not found', 404);
});
