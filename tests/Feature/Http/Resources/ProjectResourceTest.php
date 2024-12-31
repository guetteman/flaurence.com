<?php

use App\Http\Resources\ProjectResource;
use App\Models\Project;

covers(ProjectResource::class);

describe('ProjectResource', function () {
    it('should format a project', function () {
        $project = Project::factory()
            ->create();

        $resource = new ProjectResource($project);

        expect($resource->resolve())->toMatchArray([
            'id' => $project->id,
            'name' => $project->name,
            'topic' => $project->topic,
            'description' => $project->description,
            'cron_expression' => $project->cron_expression,
            'timezone' => $project->timezone,
            'user_id' => $project->user_id,
        ]);
    });
});
