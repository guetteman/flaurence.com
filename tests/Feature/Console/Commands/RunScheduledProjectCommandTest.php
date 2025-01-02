<?php

use App\Console\Commands\RunScheduledProjectCommand;
use App\Enums\LemonSqueezySubscriptionStatusEnum;
use App\Jobs\ScheduledProjectRunJob;
use App\Models\Project;
use App\Models\Run;
use LemonSqueezy\Laravel\Subscription;

covers(RunScheduledProjectCommand::class);

describe('RunScheduledProjectCommand', function () {
    it('can run scheduled projects', function () {
        Queue::fake();

        $project = Project::factory()->create([
            'cron_expression' => '0 0 * * *',
        ]);

        $project->user->update([
            'credits' => 100,
        ]);

        Subscription::factory()->create([
            'billable_id' => $project->user->id,
            'status' => LemonSqueezySubscriptionStatusEnum::Active->value
        ]);

        Run::factory()->for($project)->create([
            'created_at' => now()->subDay(),
        ]);

        $this->artisan(RunScheduledProjectCommand::class)->assertSuccessful();

        Queue::assertPushed(ScheduledProjectRunJob::class, function ($job) use ($project) {
            return $job->project->id === $project->id;
        });
    });

    it('runs project if user is on trial', function () {
        Queue::fake();

        $project = Project::factory()->create([
            'cron_expression' => '0 0 * * *',
        ]);

        $project->user->update([
            'credits' => 100,
        ]);

        Subscription::factory()->create([
            'billable_id' => $project->user->id,
            'status' => LemonSqueezySubscriptionStatusEnum::OnTrial->value
        ]);

        $this->artisan(RunScheduledProjectCommand::class)->assertSuccessful();

        Queue::assertNotPushed(ScheduledProjectRunJob::class);
    });
});
