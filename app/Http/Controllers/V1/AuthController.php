<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $device = $data['device_name'] ?? 'api-token';
        $token = $user->createToken($device, ['*'])->plainTextToken;

        return (new UserResource($user))
            ->additional([
                'meta' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ],
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }

        $device = $data['device_name'] ?? 'api-token';
        $token = $user->createToken($device, ['*'])->plainTextToken;

        return (new UserResource($user))
            ->additional(['meta' => ['access_token' => $token, 'token_type' => 'Bearer']])
            ->response()
            ->setStatusCode(200);
    }
}
