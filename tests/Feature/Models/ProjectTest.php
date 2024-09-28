<?php

use App\Models\Flow;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
});
