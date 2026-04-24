<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getCurrentUser() {

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
