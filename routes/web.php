<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;

use App\Models\Service;
use App\Models\Table;

Route::get('/', function () {
    $meals = Service::where('type', 'meal')->get();
    $drinks = Service::where('type', 'drink')->get();
    
    // Fetch counts of available tables per category
    $standardCount = Table::where('category', 'Standard')->where('status', 'available')->count();
    $mediumCount = Table::where('category', 'Medium')->where('status', 'available')->count();
    $firstClassCount = Table::where('category', 'First Class')->where('status', 'available')->count();
    
    // Fetch all available tables for the reservation modal
    // Map them to ensure IDs are strings for Alpine.js
    $availableTables = Table::where('status', 'available')->get()->map(function($table) {
        return [
            'id' => (string)$table->_id,
            'title' => $table->title,
            'category' => $table->category,
            'seats' => $table->seats,
            'status' => $table->status,
        ];
    });
    
    // Fetch gallery images
    $gallery = \App\Models\Gallery::latest()->get();
    
    return view('welcome', compact('meals', 'drinks', 'standardCount', 'mediumCount', 'firstClassCount', 'availableTables', 'gallery'));
});

Route::post('/reserve', [\App\Http\Controllers\ReservationController::class, 'publicStore'])->name('public.reserve');
Route::post('/order', [\App\Http\Controllers\OrderController::class, 'store'])->name('public.order');

Route::middleware(['auth', '2fa'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/reservations', [DashboardController::class, 'reservations']);
    Route::get('/tables', [DashboardController::class, 'tables'])->name('dashboard.tables');
    
    // Table Management Routes
    Route::post('/tables', [\App\Http\Controllers\TableController::class, 'store'])->name('tables.store');
    Route::patch('/tables/{id}/toggle', [\App\Http\Controllers\TableController::class, 'toggleStatus'])->name('tables.toggle');
    Route::delete('/tables/{id}', [\App\Http\Controllers\TableController::class, 'destroy'])->name('tables.destroy');
    
    // Reservation Routes
    Route::post('/reservations', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.store');
    Route::patch('/reservations/{id}', [\App\Http\Controllers\ReservationController::class, 'update'])->name('reservations.update');
    
    Route::get('/services', [DashboardController::class, 'services']);
    
    // Menu Management (Services) Routes
    Route::post('/services', [\App\Http\Controllers\ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{id}', [\App\Http\Controllers\ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [\App\Http\Controllers\ServiceController::class, 'destroy'])->name('services.destroy');
    
    Route::get('/events', [DashboardController::class, 'events']);
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::patch('/events/{id}/status', [\App\Http\Controllers\EventController::class, 'updateStatus'])->name('events.status');
    Route::delete('/events/{id}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/gallery', [DashboardController::class, 'gallery']);
    Route::post('/gallery', [\App\Http\Controllers\GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{id}', [\App\Http\Controllers\GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/my-orders', [DashboardController::class, 'myOrders']);
    Route::get('/cashier', [DashboardController::class, 'cashier']);
    Route::post('/sales', [DashboardController::class, 'storeSale'])->name('sales.store');

    Route::get('/orders/{id}/receipt', [\App\Http\Controllers\OrderController::class, 'printReceipt'])->name('orders.receipt');
    Route::get('/reports/print', [DashboardController::class, 'printReport'])->name('reports.print');

    Route::get('/staff-accounts', [DashboardController::class, 'staffAccounts'])->name('staff.index');
    Route::get('/user-accounts', [DashboardController::class, 'userAccounts'])->name('users.index');
    Route::post('/accounts', [DashboardController::class, 'storeAccount'])->name('accounts.store');
    Route::put('/accounts/{id}', [DashboardController::class, 'updateAccount'])->name('accounts.update');
    Route::delete('/accounts/{id}', [DashboardController::class, 'destroyAccount'])->name('accounts.destroy');
    Route::delete('/orders/clear-all', [\App\Http\Controllers\OrderController::class, 'clearAll'])->name('orders.clear-all');
    Route::delete('/reservations/clear-all', [\App\Http\Controllers\ReservationController::class, 'clearAll'])->name('reservations.clear-all');
    Route::patch('/accounts/{id}/toggle-status', [DashboardController::class, 'toggleStatus'])->name('accounts.toggle-status');
    Route::patch('/accounts/{id}/toggle-2fa', [DashboardController::class, 'toggle2FA'])->name('accounts.toggle-2fa');

    Route::get('/notifications', [DashboardController::class, 'notifications']);
    Route::post('/notifications', [\App\Http\Controllers\NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/reports', [DashboardController::class, 'reports']);
    Route::get('/profile', [DashboardController::class, 'profile']);
    Route::put('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/settings', [DashboardController::class, 'settings']);
    Route::patch('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
});
    
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/verify-account', [AuthController::class, 'showVerifyAccount'])->name('account.verify');
Route::post('/verify-account', [AuthController::class, 'confirmVerification'])->name('account.verify.post');

Route::get('/verify-2fa', [AuthController::class, 'showVerify'])->name('2fa.verify');
Route::post('/verify-2fa', [AuthController::class, 'verifyCode'])->name('2fa.verify.post');
