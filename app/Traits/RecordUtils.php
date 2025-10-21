<?php

namespace App\Traits;

use Filament\Notifications\Notification;

trait RecordUtils {
    public static function shouldBeVisibleIn($key){
        $label = strtolower(static::$modelLabel);
        
        if(!is_array($key)) return str_contains($label, $key);

        return !!array_filter($key, fn($k) => str_contains($label, $k));

    }

    public static function showResponse($response){
        Notification::make()
            ->when($response['success'], function (Notification $notification) {
                $notification->title('Success')
                    ->iconColor('success')
                    ->color('success')
                    ->icon('heroicon-o-check-circle');
            })
            ->unless($response['success'], function (Notification $notification) {
                $notification->title('Something went wrong')
                    ->iconColor('danger')
                    ->color('danger')
                    ->icon('heroicon-o-exclamation-circle');
            })
            ->body($response['message'])
            ->send();    
    }
        
}