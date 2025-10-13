<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\BoarderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceReportController; // ✅ correct one
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;


// Load auth routes from Breeze
require __DIR__.'/auth.php';

// Public home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard (requires authentication)
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Routes that require authentication
Route::middleware('auth')->group(function () {

    // Resource routes
    Route::resource('rooms', RoomController::class);
    Route::resource('boarders', BoarderController::class);

    // ❌ remove old MaintenanceController resource
    // Route::resource('maintenance', MaintenanceController::class);

    // Payments
    Route::get('payments', [PaymentController::class,'index'])->name('payments.index');
    Route::post('payments/checkout', [PaymentController::class,'checkout'])->name('payments.checkout');
    Route::post('payments/webhook', [PaymentController::class,'webhook'])->name('payments.webhook');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Assign boarder to room
    Route::post('/rooms/{room}/assign', [RoomController::class, 'assignBoarder'])->name('rooms.assignBoarder');

    // Admin-only routes (use class reference)
    // ✅ Admin-only routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
});

// ✅ Allow both Admin and User (controller checks who can access)
Route::middleware('auth')->group(function () {
    Route::get('accounts/{user}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('accounts/{user}', [AccountController::class, 'update'])->name('accounts.update');
});


    // Boarder assignment management
    Route::post('/rooms/{room}/unassign/{boarder}', [RoomController::class, 'unassignBoarder'])
        ->name('rooms.unassignBoarder');
    Route::post('/rooms/{room}/transfer/{boarder}', [RoomController::class, 'transferBoarder'])
        ->name('rooms.transferBoarder');

    // ✅ Maintenance Reports
    Route::get('/maintenance-reports', [MaintenanceReportController::class, 'index'])->name('maintenance_reports.index');
    Route::post('/maintenance-reports', [MaintenanceReportController::class, 'store'])->name('maintenance_reports.store');
    Route::post('/maintenance-reports/{report}/status', [MaintenanceReportController::class, 'updateStatus'])->name('maintenance_reports.updateStatus');

    Route::post('/payments/update-gcash', [PaymentController::class, 'updateGcash'])
    ->name('payments.updateGcash')
    ->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/payments/index', [BillController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [BillController::class, 'create'])->name('payments.create');
    Route::post('/payments/index', [BillController::class, 'store'])->name('payments.store');
    Route::delete('/payments/{id}/delete', [BillController::class, 'destroyBill'])->name('payments.destroyBill');


});

});

