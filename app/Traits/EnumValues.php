<?php
namespace App\Traits;

trait EnumValues {
    public static function values() : array {
        // return array_map(fn($item) => $item->value, self::cases());
        return array_column(self::cases(), 'value');
    }
}