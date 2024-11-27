<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PlanTypeEnum: string implements HasLabel
{
    case Monthly = 'monthly';
    case Yearly = 'yearly';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Monthly => 'Monthly',
            self::Yearly => 'Yearly',
        };
    }
}
