<?php

use App\Models\Project;
use Illuminate\Database\Eloquent\Casts\ArrayObject;

describe('Project model', function () {
    it('should cast input to ArrayObject', function () {
        $project = Project::factory()->create([
            'input' => ['foo' => 'bar'],
        ]);

        expect($project->input)->toBeInstanceOf(ArrayObject::class);
    });

    it('should cast output to ArrayObject', function () {
        $project = Project::factory()->create([
            'input' => ['foo' => 'bar'],
        ]);

        expect($project->output)->toBeInstanceOf(ArrayObject::class);
    });

    it('should cast enabled column to boolean', function () {
        $project = Project::factory()->create([
            'enabled' => 1,
        ]);

        expect($project->enabled)->toBeTrue();
    });
});
