<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json(['user'=> $user, 'token' => $token]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
    public function getCurrentUser()
    {
        return response()->json(Auth::user());
    }
    public function logout()
    {

        Auth::user()->tokens()->delete();
        return response([
            'message' => 'Successfully logged out'
        ]);
    }
}
