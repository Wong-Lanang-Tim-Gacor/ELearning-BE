<?php

namespace App\Enums;

enum OptionsTypeEnum: string
{
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case CHECKBOX = 'checkbox';
    case SELECT = 'select';
    case RADIO = 'radio';


    public static function toArray(): array
    {
        return [
            self::TEXT->value,
            self::TEXTAREA->value,
            self::CHECKBOX->value,
            self::SELECT->value,
            self::RADIO->value,
        ];
    }
}
