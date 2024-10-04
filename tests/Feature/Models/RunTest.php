<?php

use App\Enums\RunStatusEnum;
use App\Models\Project;
use App\Models\Run;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

describe('Run model', function () {
    it('should cast output to array', function () {
        $run = Run::factory()->create([
            'output' => ['foo' => 'bar'],
        ]);

        expect($run->output)->toBeArray();
    });

    it('should have project relationship', function () {
        $run = Run::factory()->create();

        expect($run->project())->toBeInstanceOf(BelongsTo::class)
            ->and($run->project()->getRelated())->toBeInstanceOf(Project::class);
    });

    it('should cast status to enum', function () {
        $run = Run::factory()->create([
            'status' => 'queued',
        ]);

        expect($run->status)->toBeInstanceOf(RunStatusEnum::class);
    });

    it('should have soft deletes', function () {
        $run = Run::factory()->create();
        $run->delete();
        expect($run->trashed())->toBeTrue();
    });
});
