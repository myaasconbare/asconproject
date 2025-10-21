<?php

namespace App\Providers;

use App\Models\MatrixEnrollment;
use App\Models\MatrixPlan;
use App\Models\MatrixSetting;
use App\Models\Setting;
use App\Services\MatrixService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        // $this->app->bind(MatrixService::class, function($app) {
        //     return new MatrixService(
        //         $app->make(MatrixSetting::class),
        //         $app->make(MatrixEnrollment::class), 
        //         $app->make(MatrixPlan::class)
        //     );
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('nowpayment', function() {
            $SiteSettings = Setting::first();
            
            $apiKey = $SiteSettings ? $SiteSettings->deposit_api_key : "";

            return Http::withHeaders([
                'x-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->baseUrl('https://api.nowpayments.io/v1');
        });
    }
}
