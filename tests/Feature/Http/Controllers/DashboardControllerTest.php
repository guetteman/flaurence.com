<?php

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

covers(DashboardController::class);

describe('DashboardController', function () {
    it('shows the user projects', function () {
        $user = User::factory()->hasProjects(3)->create();

        $this->actingAs($user);

        $response = $this->get(route('dashboard'));

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('DashboardPage')
            ->has('projects.data', 3)
        );
    });

    it('redirects to login if user is not authenticated', function () {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    });
});
