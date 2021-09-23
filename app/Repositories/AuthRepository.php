<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthRepository
{
    public function login(array $data)
    {
        $validated = Validator::make($data, [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ], [
            'email.exists' => 'Email not found'
        ]);

        if ($validated->fails()) {
            return ResponseHelper::responseFail($validated->errors()->messages(), 404);
        }

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        try {
            if (!$token = auth()->attempt($credentials)) {
                // return response()->json(['error' => 'Unauthorized'], 401);
                return ResponseHelper::responseFail(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 500);
        }


        return $this->respondWithToken($token);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
