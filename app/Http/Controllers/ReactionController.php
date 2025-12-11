<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReactionRequest;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store(StoreReactionRequest $request, $recipeId) {
        
        try {
            $reactionType = $request['reaction_type'];

            $existingReaction = Reaction::where('recipe_id', $recipeId)
                    ->where('user_id', auth()->id())
                    ->first();

            if ($existingReaction && $existingReaction->reaction_type === $reactionType){
                $existingReaction->delete();
                return response()->json(['message' => 'Removed reaction']);
            } else if ($existingReaction && $existingReaction->reaction_type !== $reactionType){
                $existingReaction->reaction_type = $reactionType;
                $existingReaction->save();
            } else {
                Reaction::create([
                    'recipe_id' => $recipeId,
                    'user_id' => auth()->id(),
                    'reaction_type' => $reactionType
                ]);
            }

            return response()->json([
                'message' => 'Reaction success'
            ], 201);

        } catch (\Exception $e){
            return response()->json([
                'message' => 'Reaction failed',
                'error' => $e->getMessage()
            ], 500);
        }
         
    }
}
