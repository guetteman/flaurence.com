<?php

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Validation\ValidationException;

covers(ResetUserPassword::class);

describe('ResetUserPassword Action', function () {
    it('resets user password', function () {
        $user = User::factory()->create();

        app(ResetUserPassword::class)->reset($user, [
            'password' => 'password2',
            'password_confirmation' => 'password2',
        ]);

        $this->assertTrue(Hash::check('password2', $user->fresh()->password));
    });

    it('validates password', function () {
        $user = User::factory()->create();

        app(ResetUserPassword::class)->reset($user, [
            'password' => 'password',
            'password_confirmation' => 'invalid-password',
        ]);
    })->throws(ValidationException::class, 'The password field confirmation does not match.');
});
