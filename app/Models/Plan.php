<?php

namespace App\Models;

use App\Enums\PlanTypeEnum;
use Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /** @use HasFactory<PlanFactory> */
    use HasFactory;

    protected $casts = [
        'active' => 'boolean',
        'type' => PlanTypeEnum::class,
    ];

    protected $guarded = [];

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->price / 100, 2, '.', ','),
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
