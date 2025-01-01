<?php

use App\Models\User;
use Filament\Panel;

describe('User Model', function () {
    it('hides the password field', function () {
        $user = User::factory()->create();

        $this->assertArrayNotHasKey('password', $user->toArray());
    });

    it('hides remember_token field', function () {
        $user = User::factory()->create();

        $this->assertArrayNotHasKey('remember_token', $user->toArray());
    });

    it('gives access to admin panel if user is admin and email is verified', function () {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        config(['admin.email' => $user->email]);

        $this->assertTrue($user->canAccessPanel(new Panel));
    });

    it('has many projects', function () {
        $user = User::factory()->hasProjects(3)->create();

        $this->assertCount(3, $user->projects);
    });

    it('can reduce credits', function () {
        $user = User::factory()->create([
            'credits' => 10,
        ]);
        $user->reduceCredits(10);
        $this->assertEquals(0, $user->credits);
    });

    it('can add credits', function () {
        $user = User::factory()->create();
        $user->addCredits(10);
        $this->assertEquals(10, $user->credits);
    });
});
