<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LemonSqueezySubscriptionStatusEnum: string implements HasLabel
{
    case OnTrial = 'on_trial';
    case Active = 'active';
    case Paused = 'paused';
    case PastDue = 'past_due';
    case Unpaid = 'unpaid';
    case Cancelled = 'cancelled';
    case Expired = 'expired';
    case Default = 'default';

    public function getLabel(): string
    {
        return match ($this) {
            self::OnTrial => 'On Trial',
            self::Active => 'Active',
            self::Paused => 'Paused',
            self::PastDue => 'Past Due',
            self::Unpaid => 'Unpaid',
            self::Cancelled => 'Cancelled',
            self::Expired => 'Expired',
            self::Default => 'Default',
        };
    }
}
