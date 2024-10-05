<?php

use App\Models\Flow;
use App\Models\Project;
use App\Models\Run;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

describe('Project model', function () {
    it('should cast input to ArrayObject', function () {
        $project = Project::factory()->create([
            'input' => ['foo' => 'bar'],
        ]);

        expect($project->input)->toBeArray();
    });

    it('should cast enabled column to boolean', function () {
        $project = Project::factory()->create([
            'enabled' => 1,
        ]);

        expect($project->enabled)->toBeTrue();
    });

    it('should return a BelongsTo relationship with Flow', function () {
        $project = Project::factory()->create();

        expect($project->flow())->toBeInstanceOf(BelongsTo::class)
            ->and($project->flow()->getRelated())->toBeInstanceOf(Flow::class);
    });

    it('should return a BelongsTo relationship with User', function () {
        $project = Project::factory()->create();

        expect($project->user())->toBeInstanceOf(BelongsTo::class)
            ->and($project->user()->getRelated())->toBeInstanceOf(User::class);
    });

    it('should return a HasMany relationship with Run', function () {
        $project = Project::factory()
            ->hasRuns(3)
            ->create();

        expect($project->runs())->toBeInstanceOf(HasMany::class)
            ->and($project->runs()->getRelated())->toBeInstanceOf(Run::class);
    });
});
