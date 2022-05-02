<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\PassportAuthRequest;

class PassportAuthController extends Controller
{
    public function login(PassportAuthRequest $request)
    {
        $validated = $request->validated();

        if (!auth()->attempt($validated)) {
            return response()->json(['message' => 'Failed to log in'], 401);
        }

        $user = auth()->user()->createToken('authToken');

        return response()->json([
            'user' => auth()->user(),
            'access_token' => $user->accessToken
        ], 200);
    }

    public function register(PassportAuthRequest $request)
    {
        $validated = $request->safe()->except('privacy');

        User::create(
            array_merge(
                $validated,
                [
                    'password' => Hash::make($validated['password'])
                ]
            )
        );

        return response()->json([
            'message' => 'User successfully registered'
        ], 200);
    }

    public function me(PassportAuthRequest $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user], 200);
    }

    public function logout(PassportAuthRequest $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You have been successfully logged out'
        ], 200);
    }
}
