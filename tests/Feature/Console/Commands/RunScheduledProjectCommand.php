<?php

use App\Console\Commands\RunScheduledProjectCommand;
use App\Jobs\ScheduledProjectRunJob;
use App\Models\Project;
use App\Models\Run;

covers(RunScheduledProjectCommand::class);

describe('RunScheduledProjectCommand', function () {
    it('can run scheduled projects', function () {
        Queue::fake();

        $project = Project::factory()->create([
            'cron_expression' => '0 0 * * *',
        ]);

        Run::factory()->for($project)->create([
            'created_at' => now()->subDay(),
        ]);

        $this->artisan(RunScheduledProjectCommand::class)->assertSuccessful();

        Queue::assertPushed(ScheduledProjectRunJob::class, function ($job) use ($project) {
            return $job->project->id === $project->id;
        });
    });
});
