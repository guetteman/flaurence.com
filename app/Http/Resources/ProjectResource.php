<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Project
 */
class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'topic' => $this->topic,
            'description' => $this->description,
            'urls' => $this->urls,
            'cron_expression' => $this->cron_expression,
            'timezone' => $this->timezone,
            'enabled' => $this->enabled,
            'user_id' => $this->user_id,
        ];
    }
}
