<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        return $this->createNewToken($token);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->authRepository->register($request);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user()
        ]);
    }

}
