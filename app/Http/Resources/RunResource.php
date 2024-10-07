<?php

namespace App\Http\Resources;

use App\Models\Run;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\LaravelMarkdown\MarkdownRenderer;

/**
 * @mixin Run
 */
class RunResource extends JsonResource
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
            'status' => $this->status,
            'status_label' => $this->status->getLabel(),
            'spent_credits' => $this->spent_credits,
            'output' => $this->formattedOutput(),
            'error' => $this->error,
            'project_id' => $this->project_id,
            'project' => new ProjectResource($this->project),
            'created_at' => $this->created_at,
            'created_at_for_humans' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'updated_at_for_humans' => $this->updated_at->diffForHumans(),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function formattedOutput(): ?array
    {
        $output = $this->output;

        if (isset($this->output['markdown'])) {
            $output['markdown'] = app(MarkdownRenderer::class)->toHtml($this->output['markdown']);
        }

        return $output;
    }
}
