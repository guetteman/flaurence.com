<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** @use HasFactory<Factory<static>> */
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean',
        'input' => 'array',
    ];

    /**
     * @return BelongsTo<Flow, self>
     */
    public function flow(): BelongsTo
    {
        return $this->belongsTo(Flow::class);
    }
}
