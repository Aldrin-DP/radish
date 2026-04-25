<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

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

    public function show($slug) {

        try {
            $user = User::with(['recipes' => function($q) {
                            $q->withCount('comments');
                        }])
                        ->where('slug', $slug)
                        ->latest()
                        ->first();

            return response()->json([
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch users recipe',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
