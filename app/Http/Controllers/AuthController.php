<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        /** @var \App\Models\User $user */
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $token = $user->createToken('main')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token, 'message' => 'Perform signup successfully']);
    }
    public function login(LoginRequest $request)
    {

        $credentials = $request->input();
        $remember = $credentials['remember'];
        unset($credentials['remember']);
        if (!Auth::attempt($credentials, $remember))
        {
            return response()->json(['message' => 'Sorry, credentials are not correct'], 422);
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token, 'message' => 'Perform login successfully']);
    }

    public function logout()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json(['success' => true]);
    }
}
