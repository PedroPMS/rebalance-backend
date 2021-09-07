<?php

namespace App\Repositories;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthRepository
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create(
            [
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]
        );
        return response()->json(['message' => 'User successfully registered', 'user' => $user], 201);
    }
}
