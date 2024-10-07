<?php

use App\Http\Resources\ProjectResource;
use App\Http\Resources\RunResource;
use App\Models\Run;

covers(RunResource::class);

describe('RunResource', function () {
    it('should format a run', function () {
        $run = Run::factory()
            ->create([
                'output' => ['markdown' => '# Hello world'],
            ])
            ->load('project');

        $resource = RunResource::make($run)->resolve();

        expect($resource)->toMatchArray([
            'id' => $run->id,
            'status' => $run->status,
            'status_label' => $run->status->getLabel(),
            'spent_credits' => $run->spent_credits,
            'output' => ['markdown' => "<h1 id=\"hello-world\">Hello world</h1>\n"],
            'error' => $run->error,
            'project_id' => $run->project_id,
            'project' => new ProjectResource($run->project),
            'created_at' => $run->created_at,
            'created_at_for_humans' => $run->created_at->diffForHumans(),
            'updated_at' => $run->updated_at,
            'updated_at_for_humans' => $run->updated_at->diffForHumans(),
        ]);
    });

    it('should format a run without markdown', function () {
        $run = Run::factory()
            ->create([
                'output' => ['foo' => 'bar'],
            ])
            ->load('project');

        $resource = RunResource::make($run)->resolve();

        expect($resource)->toMatchArray([
            'id' => $run->id,
            'status' => $run->status,
            'status_label' => $run->status->getLabel(),
            'output' => ['foo' => 'bar'],
            'error' => $run->error,
            'project_id' => $run->project_id,
            'project' => new ProjectResource($run->project),
            'created_at' => $run->created_at,
            'created_at_for_humans' => $run->created_at->diffForHumans(),
            'updated_at_for_humans' => $run->updated_at->diffForHumans(),
        ]);
    });
});
