<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggleFavorite($recipeId) {

        try {

            $userId = auth()->id();
            $favorite = Favorite::where('user_id', $userId)
                ->where('recipe_id', $recipeId)
                ->first();


            if ($favorite) {
                $favorite->delete();

                return response()->json([
                    'message' => 'Removed from favorites',
                    'isFavorited' => false
                ]);

            } else {
                Favorite::create([
                    'user_id' => $userId,
                    'recipe_id' => $recipeId
                ]);

                return response()->json([
                    'message' => 'Added to favorites',
                    'recipe' => $favorite,
                    'isFavorited' => true
                ], 201);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to toggle favorite',
                'error' => $e->getMessage(),
            ], 500);
        }

    }
    public function index() {
        try {
            $recipes = Recipe::withCount('comments')
                ->whereHas('favorites', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->get();

            return response()->json([
                'recipes' => $recipes
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed fetching favorite recipes',
                'error' => $e->getMessage()
            ],500);
        }

    }
}
