<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    private const ROUTE = 'auth.register';

    public function testSuccess()
    {
        $user = User::factory()->make()->toArray();

        $response = $this->postJson(route(self::ROUTE), [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['message' => 'User successfully registered']);
    }

    public function testFailNoDataSent()
    {
        $response = $this->postJson(route(self::ROUTE), []);
        $response->assertStatus(422);
    }

    public function testFailEmailAlreadyBeenTaken()
    {
        User::factory()->create(['email' => 'test@gmail.com']);
        $user = User::factory()->make(['email' => 'test@gmail.com'])->toArray();

        $response = $this->postJson(route(self::ROUTE), [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email' => 'The email has already been taken.']);
    }

    public function testFailWrongPasswordConfirmation()
    {
        $user = User::factory()->make()->toArray();

        $response = $this->postJson(route(self::ROUTE), [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => 'secret123',
            'password_confirmation' => 'secret1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password' => 'The password confirmation does not match.']);
    }
}
