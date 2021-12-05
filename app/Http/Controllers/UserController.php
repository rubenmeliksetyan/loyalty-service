<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\LoginRequest;
use App\Interfaces\Services\IUserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register(CreateRequest $request, IUserService $service): JsonResponse
    {
        $user = $service->createUser($request->only('name', 'email', 'password'));
        return response()->json(['user' => $user, 'token' => $service->generateToken($user)], 201);
    }

    public function login(LoginRequest $request, IUserService $service): JsonResponse
    {
        try {
            $user = $service->login($request->input('email'), $request->input('password'));
            return response()->json(['user' => $user, 'token' => $service->generateToken($user)], 201);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Bad credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ['message' => 'Logged out'];
    }
}
