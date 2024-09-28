<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TextInputTypeEnum: string implements HasLabel
{
    case Text = 'text';
    case Number = 'number';
    case Email = 'email';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Text => 'Text',
            self::Number => 'Number',
            self::Email => 'email',
        };
    }
}
