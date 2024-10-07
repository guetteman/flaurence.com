<?php

namespace App\Jobs;

use App\Domain\Graphs\Newsletter\NewsletterGraph;
use App\Enums\RunStatusEnum;
use App\Models\Run;
use App\Notifications\NewsletterNotification;
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
            $graph = app($this->run->project->flow->external_id);
            $state = $graph->invoke(
                input: $this->run->project->input,
                id: $this->run->id,
            );

            $this->run->update([
                'status' => RunStatusEnum::Completed,
                'output' => ['markdown' => $state->output],
            ]);

            if ($graph instanceof NewsletterGraph) {
                $this->run->project->user->notify(new NewsletterNotification(
                    subject: $this->run->project->name,
                    content: $state->output,
                ));
            }
        } catch (Throwable $e) {
            $this->run->update([
                'status' => RunStatusEnum::Failed,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
