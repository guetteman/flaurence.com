<?php

use App\Http\Controllers\ProjectController;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

covers(ProjectController::class, StoreProjectRequest::class, UpdateProjectRequest::class);

describe('ProjectController create', function () {
    it('redirects to login if user is not authenticated', function () {
        $response = $this->get(route('projects.create'));

        $response->assertRedirect(route('login'));
    });
});

describe('ProjectController store', function () {
    it('should create projects enabled by default', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertRedirect(route('dashboard'));

        $project = $user->projects()->first();

        expect($project)
            ->name->toBe('My project')
            ->topic->toBe('My topic')
            ->description->toBe('My description')
            ->urls->toBe(['https://example.com'])
            ->cron_expression->toBe('0 0 * * *')
            ->enabled->toBeTrue();
    });

    it('should redirect to login if user is not authenticated', function () {
        $response = $this->post(route('projects.store'));

        $response->assertRedirect(route('login'));
    });

    it('validates name is required', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    });

    it('validates name is a string', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 123,
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['name' => 'The name field must be a string.']);
    });

    it('validates name is not greater than 255 characters', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => str_repeat('a', 256),
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['name' => 'The name field must not be greater than 255 characters.']);
    });

    it('validates topic is required', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['topic' => 'The topic field is required.']);
    });

    it('validates topic is a string', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 123,
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['topic' => 'The topic field must be a string.']);
    });

    it('validates topic is not greater than 255 characters', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => str_repeat('a', 256),
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['topic' => 'The topic field must not be greater than 255 characters.']);
    });

    it('validates description is a string', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 123,
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['description' => 'The description field must be a string.']);
    });

    it('validates description is not greater than 500 characters', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => str_repeat('a', 501),
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['description' => 'The description field must not be greater than 500 characters.']);
    });

    it('validates urls is required', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['urls' => 'The urls field is required.']);
    });

    it('validates urls is an array', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => 'not-an-array',
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['urls' => 'The urls field must be an array.']);
    });

    it('validates urls are valid urls', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['not-a-url'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['urls.0' => 'The urls.0 field must be a valid URL.']);
    });

    it('validates urls has at least one item', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => [],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['urls' => 'The urls field is required.']);
    });

    it('validates cron_expression is required', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
            ])
            ->assertSessionHasErrors(['cron_expression' => 'The cron expression field is required.']);
    });

    it('validates cron_expression is a string', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => 123,
            ])
            ->assertSessionHasErrors(['cron_expression' => 'The cron expression field must be a string.']);
    });

    it('validates cron_expression is not shorter than 9 characters', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * *',
            ])
            ->assertSessionHasErrors(['cron_expression' => 'The cron expression field must be at least 9 characters.']);
    });
});

describe('ProjectController show', function () {
    it('should show a project', function () {
        $project = Project::factory()
            ->hasRuns(3)
            ->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('projects.show', $project))
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Projects/ShowPage')
                    ->has('runs.data', 3)
                    ->has('project.data', fn (AssertableInertia $page) => $page
                        ->where('id', $project->id)
                        ->where('name', $project->name)
                        ->where('topic', $project->topic)
                        ->where('description', $project->description)
                        ->where('urls', $project->urls)
                        ->where('cron_expression', $project->cron_expression)
                        ->where('timezone', $project->timezone)
                        ->where('enabled', $project->enabled)
                        ->where('user_id', $project->user_id)
                    )
            );
    });

    it('redirects to login if user is not authenticated', function () {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.show', $project));

        $response->assertRedirect(route('login'));
    });
});

describe('ProjectController edit', function () {
    it('should provide project', function () {
        $project = Project::factory()->create();
        $this->actingAs($project->user)
            ->get(route('projects.edit', $project))
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Projects/EditPage')
                    ->has('project.data', fn (AssertableInertia $page) => $page
                        ->where('id', $project->id)
                        ->where('name', $project->name)
                        ->where('topic', $project->topic)
                        ->where('description', $project->description)
                        ->where('urls', $project->urls)
                        ->where('cron_expression', $project->cron_expression)
                        ->where('timezone', $project->timezone)
                        ->where('enabled', $project->enabled)
                        ->where('user_id', $project->user_id)
                    )
            );
    });

    it('redirects to login if user is not authenticated', function () {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.edit', $project));

        $response->assertRedirect(route('login'));
    });
});

describe('ProjectController update', function () {
    it('should update project', function () {
        $project = Project::factory()->create([
            'name' => 'My project',
            'topic' => 'My topic',
            'description' => 'My description',
            'urls' => ['https://example.com'],
            'cron_expression' => '0 0 * * *',
        ]);

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'Updated project',
                'topic' => 'Updated topic',
                'description' => 'Updated description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertRedirect(route('projects.show', $project));

        $project->refresh();
        expect($project->name)->toBe('Updated project')
            ->and($project->topic)->toBe('Updated topic')
            ->and($project->description)->toBe('Updated description')
            ->and($project->urls)->toBe(['https://example.com'])
            ->and($project->cron_expression)->toBe('0 0 * * *');
    });

    it('validates name is required', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    });

    it('validates name is a string', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 123,
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['name' => 'The name field must be a string.']);
    });

    it('validates name is not greater than 255 characters', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => str_repeat('a', 256),
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['name' => 'The name field must not be greater than 255 characters.']);
    });

    it('validates topic is required', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['topic' => 'The topic field is required.']);
    });

    it('validates topic is a string', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'topic' => 123,
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['topic' => 'The topic field must be a string.']);
    });

    it('validates topic is not greater than 255 characters', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'topic' => str_repeat('a', 256),
                'description' => 'My description',
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['topic' => 'The topic field must not be greater than 255 characters.']);
    });

    it('validates description is a string', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 123,
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['description' => 'The description field must be a string.']);
    });

    it('validates description is not greater than 500 characters', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => str_repeat('a', 501),
                'urls' => ['https://example.com'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['description' => 'The description field must not be greater than 500 characters.']);
    });

    it('validates urls is an array', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => 'not-an-array',
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['urls' => 'The urls field must be an array.']);
    });

    it('validates urls are valid urls', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => ['not-a-url'],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['urls.0' => 'The urls.0 field must be a valid URL.']);
    });

    it('validates urls has at least one item', function () {
        $project = Project::factory()->create();

        $this->actingAs($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'My project',
                'topic' => 'My topic',
                'description' => 'My description',
                'urls' => [],
                'cron_expression' => '0 0 * * *',
            ])
            ->assertSessionHasErrors(['urls' => 'The urls field is required.']);
    });

    it('redirects to login if user is not authenticated', function () {
        $project = Project::factory()->create();

        $response = $this->put(route('projects.update', $project));

        $response->assertRedirect(route('login'));
    });
});
