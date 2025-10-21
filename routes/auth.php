<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Middleware\RedirectPostRequest;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Route;

Route::middleware([RedirectPostRequest::class])->name('auth.')->group(function() {
    Route::middleware(['guest'])->group(function() {
        Route::match(['get', 'post'], '/login', Login::class)->name('login');
        Route::match(['get', 'post'], '/register', Register::class)->name('register');
        Route::match(['get', 'post'], '/forgot-password', ForgotPassword::class)->name('forgot-password');
        Route::match(['get', 'post'], '/reset-password/{token}/{hash}', ResetPassword::class)
            ->name('reset-password')
            ->middleware(['signed']);
    });
    Route::match(['get', 'post'], '/verify-email', VerifyEmail::class)->name('verify-email');
    
    Route::match(['get', 'post'], '/verification/{id}/{hash}', EmailVerificationController::class)
        ->name('verification')
        ->middleware(['auth', 'signed']);
});