<?php

namespace App\Models;

use App\Enums\RunStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Run extends Model
{
    /** @use HasFactory<Factory<static>> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => RunStatusEnum::class,
        'output' => 'array',
    ];

    /**
     * @return BelongsTo<Project>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
