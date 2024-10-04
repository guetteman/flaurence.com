<?php

namespace App\Jobs;

use App\Enums\RunStatusEnum;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProjectRunJob implements ShouldQueue
{
    use Queueable;

    public $tries = 1;

    public $timeout = 600;

    public $maxExceptions = 1;

    public function __construct(
        public Project $project
    ) {}

    public function handle(): void
    {
        $run = $this->project->runs()->create([
            'status' => RunStatusEnum::Running,
        ]);

        $state = app($this->project->flow->external_id)
            ->invoke($this->project->input);

        $run->update([
            'status' => RunStatusEnum::Completed,
            'output' => ['markdown' => $state->output],
        ]);
    }
}
