<?php

namespace App\Traits\Admin;

use Filament\Notifications\Notification;

trait Notify
{
    static function showResponse($details){
        return (new self)->notify($details['success'] ? 'success' : 'error', $details['message']);
    }
    
    public function notify($type, $message, $title = null){

      $type = $type == 'error' ? 'danger' : $type;

        return Notification::make()
            ->when($title, function(Notification $notification) use ($title) {
                $notification->title($title);
            })
            ->body($message)
            ->{$type}()
            ->send();
    }
}
