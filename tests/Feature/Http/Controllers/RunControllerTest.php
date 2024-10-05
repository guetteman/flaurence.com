<?php

use App\Http\Controllers\RunController;
use App\Jobs\ProjectRunJob;
use App\Models\Project;
use Inertia\Testing\AssertableInertia;

covers(RunController::class);

describe('RunController', function () {
    it('should create a run', function () {
        Queue::fake();
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->post(route('runs.store', $project))
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('runs', [
            'project_id' => $project->id,
            'status' => App\Enums\RunStatusEnum::Queued->value,
        ]);
    });

    it('should dispatch ProjectRunJob', function () {
        Queue::fake();
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->post(route('runs.store', $project));

        Queue::assertPushed(ProjectRunJob::class);
    });

    it('should show a run', function () {
        $project = Project::factory()
            ->hasRuns()
            ->create();

        $run = $project->runs->first();

        $this->actingAs($project->user)
            ->get(route('runs.show', ['project' => $project, 'run' => $project->runs()->first()]))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Runs/ShowPage')
                ->has('run.data', fn (AssertableInertia $page) => $page
                    ->where('id', $run->id)
                    ->where('status', $run->status->value)
                    ->where('output', $run->output)
                    ->where('error', $run->error)
                    ->where('project.id', $project->id)
                    ->where('created_at', $run->created_at->toJson())
                    ->etc()
                )
            );
    });

    it('redirects to login if user is not authenticated', function () {
        Queue::fake();

        $project = Project::factory()
            ->hasRuns()
            ->create();

        $this
            ->post(route('runs.store', $project))
            ->assertRedirect(route('login'));

        $this
            ->get(route('runs.show', ['project' => $project, 'run' => $project->runs()->first()]))
            ->assertRedirect(route('login'));
    });
});
