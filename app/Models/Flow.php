<?php

namespace App\Models;

use App\Enums\FlowOutputTypeEnum;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'input_schema' => AsArrayObject::class,
        'output_type' => FlowOutputTypeEnum::class,
    ];
}
