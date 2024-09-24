<?php

use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Validation\ValidationException;

covers(UpdateUserProfileInformation::class);

describe('UpdateUserProfileInformation Action', function () {
    it('updates user profile information', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
            'email' => 'test@test.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'test@test.com',
        ]);
    });

    it('validates name is required', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'email' => $user->email,
        ]);
    })->throws(ValidationException::class, 'The name field is required.');

    it('validates name is a string', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 123456,
            'email' => $user->email,
        ]);
    })->throws(ValidationException::class, 'The name field must be a string.');

    it('validates name should not be greater than 255 chars', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => str_repeat('a', 256),
            'email' => $user->email,
        ]);
    })->throws(ValidationException::class, 'The name field must not be greater than 255 characters.');

    it('validates email is required', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
        ]);
    })->throws(ValidationException::class, 'The email field is required.');

    it('validates email is an string', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
            'email' => 123456,
        ]);
    })->throws(ValidationException::class, 'The email field must be a string.');

    it('validates email is an email', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
            'email' => 'invalid-email',
        ]);
    })->throws(ValidationException::class, 'The email field must be a valid email address.');

    it('validates email should not be greater than 255 chars', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
            'email' => str_repeat('a', 256).'@example.com',
        ]);
    })->throws(ValidationException::class, 'The email field must not be greater than 255 characters.');

    it('validates email is unique', function () {
        $otherUser = User::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
            'email' => $otherUser->email,
        ]);
    })->throws(ValidationException::class, 'The email has already been taken.');

    it('resets email_verified_at field if email is changed', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
            'email' => 'test@test.com',
        ]);

        expect($user->fresh()->email_verified_at)->toBeNull();
    });

    it('sends email verification notification if email is changed', function () {
        Notification::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        app(UpdateUserProfileInformation::class)->update($user, [
            'name' => 'John Doe',
            'email' => 'test@test.com',
        ]);

        Notification::assertSentTo($user, VerifyEmail::class);
    });
});
