<?php

namespace App\Traits;

trait EnumLabel {
    public function getLabel(self $value): string{ 
        return match($value){
            default => str_replace('_', ' ', $value->value)
        };
    }

    public function label(): string {
        return $this->getLabel($this);
    }
}

