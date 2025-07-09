<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return redirect()->route('events.index');
});

// Route untuk event
Route::resource('events', EventController::class);

// Route untuk registrasi
Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
Route::get('/registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
Route::post('/events/{event}/register', [RegistrationController::class, 'register'])->name('registrations.register');
Route::post('/registrations/{registration}/cancel', [RegistrationController::class, 'cancel'])->name('registrations.cancel');

// Route untuk pembayaran
Route::get('/registrations/{registration}/payment', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/registrations/{registration}/payment', [PaymentController::class, 'store'])->name('payments.store');
Route::post('/payment-notification', [PaymentController::class, 'notification'])->name('payments.notification');

// Route untuk admin dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
});

//Route untuk profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-midtrans', function () {
    dd(config('midtrans.serverKey'));
});


require __DIR__ . '/auth.php';
