<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenTest extends TestCase
{
    private const ROUTE = 'auth.refresh';

    public function testSuccess()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withToken($token)->postJson(route(self::ROUTE));

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }
}
