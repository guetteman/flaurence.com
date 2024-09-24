<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TextInputTypeEnum: string implements HasLabel
{
    case String = 'string';
    case Number = 'number';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::String => 'String',
            self::Number => 'Number',
        };
    }
}
