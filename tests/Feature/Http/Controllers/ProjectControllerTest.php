<?php

use App\Http\Controllers\ProjectController;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Flow;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

covers(ProjectController::class, StoreProjectRequest::class);

describe('ProjectController create', function () {
    it('should provide active flows', function () {
        Flow::factory()->count(3)->enabled()->create();
        Flow::factory()->count(2)->disabled()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('projects.create'))
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Projects/CreatePage')
                    ->has('flows.data', 3)
            );
    });

    it('redirects to login if user is not authenticated', function () {
        $response = $this->get(route('projects.create'));

        $response->assertRedirect(route('login'));
    });
});

describe('ProjectController store', function () {
    it('should create projects enabled by default', function () {
        $flow = Flow::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'flow_id' => $flow->id,
                'name' => 'My project',
                'input' => ['foo' => 'bar'],
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('projects', [
            'flow_id' => $flow->id,
            'name' => 'My project',
        ]);

        $project = $flow->projects()->first();
        expect($project->input)->toBe(['foo' => 'bar'])
            ->and($project->enabled)->toBeTrue();
    });

    it('should redirect to login if user is not authenticated', function () {
        $response = $this->post(route('projects.store'));

        $response->assertRedirect(route('login'));
    });

    it('validates name is required', function () {
        $flow = Flow::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'flow_id' => $flow->id,
                'input' => ['foo' => 'bar'],
            ])
            ->assertSessionHasErrors('name');
    });

    it('validates name is a string', function () {
        $flow = Flow::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'flow_id' => $flow->id,
                'name' => 123,
                'input' => ['foo' => 'bar'],
            ])
            ->assertSessionHasErrors('name');
    });

    it('validates name is not greater than 255 characters', function () {
        $flow = Flow::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'flow_id' => $flow->id,
                'name' => str_repeat('a', 256),
                'input' => ['foo' => 'bar'],
            ])
            ->assertSessionHasErrors('name');
    });

    it('validates flow_id is required', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'input' => ['foo' => 'bar'],
            ])
            ->assertSessionHasErrors('flow_id');
    });

    it('validates flow_id exists', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'flow_id' => 999,
                'name' => 'My project',
                'input' => ['foo' => 'bar'],
            ])
            ->assertSessionHasErrors('flow_id');
    });

    it('validates input is an array', function () {
        $flow = Flow::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'flow_id' => $flow->id,
                'name' => 'My project',
                'input' => 'not-an-array',
            ])
            ->assertSessionHasErrors('input');
    });
});
