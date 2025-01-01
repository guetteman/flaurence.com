<?php

namespace App\Jobs;

use App\Enums\RunStatusEnum;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ScheduledProjectRunJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Project $project
    ) {}

    public function handle(): void
    {
        if ($this->project->user->credits <= 0) {
            return;
        }

        $run = $this->project->runs()->create([
            'status' => RunStatusEnum::Queued,
        ]);

        ProjectRunJob::dispatch($run);
    }
}
