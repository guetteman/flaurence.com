<?php

use App\Actions\Fortify\UpdateUserPassword;
use App\Models\User;
use Illuminate\Validation\ValidationException;

covers(UpdateUserPassword::class);

describe('UpdateUserPassword Action', function () {
    it('updates user password', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserPassword::class)->update($user, [
            'current_password' => 'password',
            'password' => 'password2',
            'password_confirmation' => 'password2',
        ]);

        $this->assertTrue(Hash::check('password2', $user->fresh()->password));
    });

    it('validates current password', function () {
        $user = User::factory()->create();

        app(UpdateUserPassword::class)->update($user, [
            'current_password' => 'password',
            'password' => 'password2',
            'password_confirmation' => 'password2',
        ]);
    })->throws(ValidationException::class, 'The provided password does not match your current password.');

    it('validates password', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserPassword::class)->update($user, [
            'current_password' => 'password',
            'password' => 'password2',
            'password_confirmation' => 'invalid-password',
        ]);
    })->throws(ValidationException::class, 'The password field confirmation does not match.');

    it('validates current password is a string', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserPassword::class)->update($user, [
            'current_password' => 123456,
            'password' => 'password2',
            'password_confirmation' => 'password2',
        ]);
    })->throws(ValidationException::class, 'The current password field must be a string.');

    it('validates current password is required', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserPassword::class)->update($user, [
            'password' => 'password2',
            'password_confirmation' => 'password2',
        ]);
    })->throws(ValidationException::class, 'The current password field is required.');
});
