<?php

use App\Http\Resources\FlowResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

covers(ProjectResource::class);

describe('ProjectResource', function () {
    it('should format a project', function () {
        $project = Project::factory()
            ->create()
            ->load('flow');

        $resource = ProjectResource::make($project);

        expect($resource->resolve())->toMatchArray([
            'id' => $project->id,
            'name' => $project->name,
            'input' => $project->input,
            'cron_expression' => $project->cron_expression,
            'timezone' => $project->timezone,
            'user_id' => $project->user_id,
            'flow_id' => $project->flow_id,
            'flow' => new FlowResource($project->flow),
        ]);
    });
});
