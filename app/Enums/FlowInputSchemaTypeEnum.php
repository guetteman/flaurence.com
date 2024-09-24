<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FlowInputSchemaTypeEnum: string implements HasLabel
{
    case TextInput = 'text_input';
    case TextInputRepeater = 'text_input_repeater';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TextInput => 'Text Input',
            self::TextInputRepeater => 'Text Input Repeater',
        };
    }
}
