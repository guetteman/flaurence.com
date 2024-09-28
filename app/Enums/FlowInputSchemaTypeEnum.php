<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FlowInputSchemaTypeEnum: string implements HasLabel
{
    case TextInput = 'text_input';
    case ArrayInput = 'array_input';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TextInput => 'Text Input',
            self::ArrayInput => 'Array Input',
        };
    }
}
