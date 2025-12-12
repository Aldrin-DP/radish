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
            } else if ($existingReaction && $existingReaction->reaction_type !== $reactionType){
                $existingReaction->reaction_type = $reactionType;
                $existingReaction->save();
                $wasRemoved = true;
            } else {
                Reaction::create([
                    'recipe_id' => $recipeId,
                    'user_id' => auth()->id(),
                    'reaction_type' => $reactionType
                ]);
            }
            
            $reactionCount = [
                'love' => Reaction::where('reaction_type', 'love')
                                ->where('recipe_id', $recipeId)
                                ->count(),
                'fire' => Reaction::where('reaction_type', 'fire')
                                ->where('recipe_id', $recipeId)
                                ->count(),
                'laugh' => Reaction::where('reaction_type', 'laugh')
                                ->where('recipe_id', $recipeId)
                                ->count(),
                'dislike' => Reaction::where('reaction_type', 'dislike')
                                ->where('recipe_id', $recipeId)
                                ->count()
            ];

            return response()->json([
                'message' => 'Reaction updated',
                'counts' => $reactionCount,
                'removed' => $wasRemoved
            ], 201);

        } catch (\Exception $e){
            return response()->json([
                'message' => 'Reaction failed',
                'error' => $e->getMessage()
            ], 500);
        }
         
    }
}
