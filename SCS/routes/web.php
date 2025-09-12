<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
});

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return redirect()->route('students.index');
})->name('dashboard');
