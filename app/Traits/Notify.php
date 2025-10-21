<?php

namespace App\Traits;

use App\Enums\ServerMessageTypes;

trait Notify
{
    public function notify($msg, $type){
        
        $this->js("toastr.clear()");

        return $this->dispatch('server-message', [
            'type' => $type,
            'payload' =>  $msg
        ]);
    }
    
    public function notifyError($msg, $type = ServerMessageTypes::ERROR){
        return $this->notify($msg, $type);
    }
    public function notifySuccess($msg){
        return $this->notify($msg, ServerMessageTypes::SUCCESS);
    }
}
