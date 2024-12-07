<?php

namespace App\Models;

use App\Enums\PlanTypeEnum;
use Closure;
use Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $formatted_price
 */
class Plan extends Model
{
    /** @use HasFactory<PlanFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $casts = [
        'active' => 'boolean',
        'type' => PlanTypeEnum::class,
    ];

    protected $guarded = [];

    /**
     * @return Attribute<Closure, Closure>
     */
    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->price / 100, 2, '.', ','),
        );
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
