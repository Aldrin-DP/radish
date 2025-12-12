<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function fetchCurrentUser() {

        try {
            $user = auth()->user()->load('reactions');

            return response()->json([
                'message' => 'Success',
                'user' => new UserResource($user)
            ], 200);

        } catch (\Exception $e) {   
            return response()->json([
                'message' => 'Failed fetching current user.',
                'error' => $e->getMessage()
            ],500);
        }
    }
}
