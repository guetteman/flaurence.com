<?php

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Validation\ValidationException;

covers(CreateNewUser::class);

describe('CreatNewUser Action', function () {
    it('should create a new user', function () {
        $data = User::factory()->raw();

        app(CreateNewUser::class)->create([
            ...$data,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    });

    it('validates password', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'password' => 'password',
            'password_confirmation' => 'invalid-password',
        ]);
    })->throws(ValidationException::class, 'The password field confirmation does not match.');

    it('validates user is unique', function () {
        $user = User::factory()->create();

        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The email has already been taken.');

    it('validates email is no longer than 255 chars', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'email' => str_repeat('a', 256).'@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The email field must not be greater than 255 characters.');

    it('validates email is an email', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The email field must be a valid email address.');

    it('validates email is a string', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'email' => ['email'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The email field must be a string.');

    it('validates email is required', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'email' => null,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The email field is required.');

    it('validates name is required', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'name' => null,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The name field is required.');

    it('validates name is a string', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'name' => ['name'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The name field must be a string.');

    it('validates name is no longer than 255 chars', function () {
        app(CreateNewUser::class)->create([
            ...User::factory()->raw(),
            'name' => str_repeat('a', 256),
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    })->throws(ValidationException::class, 'The name field must not be greater than 255 characters.');
});
