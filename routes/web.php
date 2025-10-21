<?php

use App\Http\Middleware\RedirectPostRequest;
use App\Livewire\Guest\Contact;
use App\Livewire\Guest\Faqs;
use App\Livewire\Guest\Features;
use App\Livewire\Guest\Home;
use App\Livewire\Guest\Pricing;
use App\Livewire\Guest\PrivacyPolicy;
use App\Livewire\Guest\Staking;
use App\Livewire\Guest\Terms;
use App\Livewire\Guest\Trade;
use Illuminate\Support\Facades\Route;


Route::middleware([RedirectPostRequest::class])->name('guest.')->group(function () {
    Route::match(['get', 'post'], '/', Home::class)->name('home');
    Route::match(['get', 'post'], '/trade', Trade::class)->name('trade');
    Route::match(['get', 'post'], '/pricing', Pricing::class)->name('pricing');
    Route::match(['get', 'post'], '/staking', Staking::class)->name('staking');
    Route::match(['get', 'post'], '/features', Features::class)->name('features');
    Route::match(['get', 'post'], '/privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
    Route::match(['get', 'post'], '/contact', Contact::class)->name('contact');
    Route::match(['get', 'post'], '/terms-and-conditions', Terms::class)->name('terms');
    Route::match(['get', 'post'], '/faqs', Faqs::class)->name('faqs');
});

