<?php

use App\Models\Project;

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
});
