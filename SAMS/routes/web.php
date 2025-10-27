<?php

use App\Http\Controllers\{
    RoomController,
    BoarderController,
    PaymentController,
    MaintenanceReportController,
    ProfileController,
    AccountController,
    BillController,
    TermsController
};
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// ✅ Auth routes (from Breeze or Jetstream)
require __DIR__.'/auth.php';

// ✅ Public home page
Route::get('/', function () {
    return view('home');
})->name('home');

// ✅ Terms & Conditions routes (available after login but before accepting)
Route::middleware('auth')->group(function () {
    Route::get('/terms', [TermsController::class, 'show'])->name('terms.show');
    Route::post('/terms/accept', [TermsController::class, 'accept'])->name('terms.accept');
});

// ✅ Protected routes that require user to be logged in AND accepted terms
Route::middleware(['auth', \App\Http\Middleware\CheckTermsAccepted::class])->group(function () {

    // ✅ Dashboard with role-based redirect
    Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


    // ✅ Rooms & Boarders
    Route::resource('rooms', RoomController::class);
    Route::resource('boarders', BoarderController::class);

    // ✅ Room actions
    Route::post('/rooms/{room}/assign', [RoomController::class, 'assignBoarder'])->name('rooms.assignBoarder');
    Route::post('/rooms/{room}/unassign/{boarder}', [RoomController::class, 'unassignBoarder'])->name('rooms.unassignBoarder');
    Route::post('/rooms/{room}/transfer/{boarder}', [RoomController::class, 'transferBoarder'])->name('rooms.transferBoarder');

    // ✅ Maintenance Reports
    Route::get('/maintenance-reports', [MaintenanceReportController::class, 'index'])->name('maintenance_reports.index');
    Route::post('/maintenance-reports', [MaintenanceReportController::class, 'store'])->name('maintenance_reports.store');
    Route::post('/maintenance-reports/{report}/status', [MaintenanceReportController::class, 'updateStatus'])->name('maintenance_reports.updateStatus');

    // ✅ Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/checkout', [PaymentController::class, 'checkout'])->name('payments.checkout');
    Route::post('/payments/webhook', [PaymentController::class, 'webhook'])->name('payments.webhook');
    Route::post('/payments/update-gcash', [PaymentController::class, 'updateGcash'])->name('payments.updateGcash');

    // ✅ Bills (admin)
    Route::get('/payments/index', [BillController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [BillController::class, 'create'])->name('payments.create');
    Route::post('/payments/index', [BillController::class, 'store'])->name('payments.store');
    Route::delete('/payments/{id}/delete', [BillController::class, 'destroyBill'])->name('payments.destroyBill');

    // ✅ Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Shared Account routes
    Route::get('accounts/{user}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('accounts/{user}', [AccountController::class, 'update'])->name('accounts.update');

    // ✅ Admin-only routes
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
        Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
    });
});
