<?php

namespace App\Jobs;

use App\Enums\RunStatusEnum;
use App\Models\Run;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class ProjectRunJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 1;

    public int $timeout = 600;

    public function __construct(
        public Run $run
    ) {}

    public function handle(): void
    {
        $this->run->update([
            'status' => RunStatusEnum::Running,
        ]);

        try {
            $state = app($this->run->project->flow->external_id)
                ->invoke($this->run->project->input);

            $this->run->update([
                'status' => RunStatusEnum::Completed,
                'output' => ['markdown' => $state->output],
            ]);
        } catch (Throwable $e) {
            $this->run->update([
                'status' => RunStatusEnum::Failed,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
