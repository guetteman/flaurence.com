<?php

use App\Models\User;

describe('User Model', function () {
    it('hides the password field', function () {
        $user = User::factory()->create();

        $this->assertArrayNotHasKey('password', $user->toArray());
    });

    it('hides remember_token field', function () {
        $user = User::factory()->create();

        $this->assertArrayNotHasKey('remember_token', $user->toArray());
    });
});
