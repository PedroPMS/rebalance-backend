<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserProfileTest extends TestCase
{
    private const ROUTE = 'auth.userProfile';

    public function testSuccess()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withToken($token)->get(route(self::ROUTE));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ]);
    }
}
