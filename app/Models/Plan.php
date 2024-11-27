<?php

namespace App\Models;

use App\Enums\PlanTypeEnum;
use Database\Factories\PlanFactory;
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
}
