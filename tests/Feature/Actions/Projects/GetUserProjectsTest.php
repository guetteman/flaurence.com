<?php

use App\Actions\Projects\GetUserProjects;
use App\Models\User;
use Illuminate\Support\Collection;

covers(GetUserProjects::class);

describe('GetUserProjects', function () {
    it('returns a collection of projects', function () {
        $user = User::factory()->hasProjects(3)->create();

        $projects = (new GetUserProjects)->execute($user);

        expect($projects)->toBeInstanceOf(Collection::class)
            ->and($projects->count())->toBe(3);
    });
});
