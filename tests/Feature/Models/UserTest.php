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

        $this->assertTrue($user->canAccessPanel(new Panel()));
    });
});
