<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private const ROUTE = 'auth.login';

    public function testSuccess()
    {
        $user = User::factory()->create(['password' => bcrypt('secret123')]);

        $response = $this->postJson(route(self::ROUTE), [
            'email' => $user->email,
            'password' => 'secret123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }

    public function testFailNoDataSent()
    {
        $response = $this->postJson(route(self::ROUTE), []);
        $response->assertStatus(422);
    }

    public function testFailWrongEmail()
    {
        User::factory()->create(['email' => 'test@gmail.com']);

        $response = $this->postJson(route(self::ROUTE), [
            'email' => 'testwrong@gmail.com',
            'password' => 'secret123'
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment(['error' => 'Invalid email or password']);
    }

    public function testFailWrongPassword()
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $response = $this->postJson(route(self::ROUTE), [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment(['error' => 'Invalid email or password']);
    }
}
