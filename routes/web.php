<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/reservations', [DashboardController::class, 'reservations']);
    Route::get('/tables', [DashboardController::class, 'tables']);
    Route::get('/services', [DashboardController::class, 'services']);
    Route::get('/events', [DashboardController::class, 'events']);
    Route::get('/gallery', [DashboardController::class, 'gallery']);
    Route::get('/orders', [DashboardController::class, 'orders']);
    Route::get('/my-orders', [DashboardController::class, 'myOrders']);
    Route::get('/cashier', [DashboardController::class, 'cashier']);
    Route::get('/staff-accounts', [DashboardController::class, 'staffAccounts']);
    Route::get('/notifications', [DashboardController::class, 'notifications']);
    Route::get('/reports', [DashboardController::class, 'reports']);
    Route::get('/profile', [DashboardController::class, 'profile']);
    Route::get('/settings', [DashboardController::class, 'settings']);
});
    
Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
