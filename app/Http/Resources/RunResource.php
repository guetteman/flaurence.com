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
            'output' => $this->outputToHtml(),
            'error' => $this->error,
            'project_id' => $this->project_id,
            'project' => new ProjectResource($this->project),
            'created_at' => $this->created_at,
        ];
    }

    public function outputToHtml(): array
    {
        $output = $this->output;

        if (isset($this->output['markdown'])) {
            $output['markdown'] = app(MarkdownRenderer::class)->toHtml($this->output['markdown']);
            return $output;
        }
        return $output;
    }
}
