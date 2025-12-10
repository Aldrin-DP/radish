<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request) {

        try {
            $credentials = $request->validated();
        
            $user = User::where('email', $credentials['email'])->first();

            if (!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'message' => 'Invalid credentials.',
                ], 422);
            } 
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successfully',
                'user' => new UserResource($user),
                'token' => $token
            ],200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed.',
                'error' => $e->getMessage()
            ], 500);
        }   
    }
    
}
