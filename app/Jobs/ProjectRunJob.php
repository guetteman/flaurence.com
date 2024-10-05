<?php

namespace App\Jobs;

use App\Enums\RunStatusEnum;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class ProjectRunJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 1;

    public int $timeout = 600;

    public function __construct(
        public Project $project
    ) {}

    public function handle(): void
    {
        $run = $this->project->runs()->create([
            'status' => RunStatusEnum::Running,
        ]);

        try {
            $state = app($this->project->flow->external_id)
                ->invoke($this->project->input);

            $run->update([
                'status' => RunStatusEnum::Completed,
                'output' => ['markdown' => $state->output],
            ]);
        } catch (Throwable $e) {
            $run->update([
                'status' => RunStatusEnum::Failed,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
