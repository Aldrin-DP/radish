<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $recipeId) {

        try {
            $validated = $request->validated();
            $comment = Comment::create([
                'user_id' => auth()->id(),
                'recipe_id' => $recipeId,
                'message' => $validated['message'],
                'parent_id' => $validated['parent_id'] ?? null
            ]);
            $comment->load('user');
            
            return response()->json([
                'comment' => new CommentResource($comment)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Comment failed.',
                'error' => $e->getMessage()
            ]);
        }   
        
    }
}
