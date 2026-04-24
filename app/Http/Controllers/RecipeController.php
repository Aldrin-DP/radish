<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request) {

        try {

            $query = Recipe::query();

           if ($request->filled('search')) {
                $query->where(function ($q) use ($request){
                    $q->where('recipe_name', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('ingredients', 'LIKE', '%' . $request->search . '%');
                });
            }

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('difficulty')) {
                $query->where('difficulty', $request->difficulty);
            }

            $recipes = $query->with('user')
                             ->withCount('comments')
                             ->latest()
                             ->paginate(20);

            return response()->json([
                'recipes' => $recipes,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch recipes.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function store(StoreRecipeRequest $request){

        try {
            $validated = $request->validated();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('recipes', 'public');
                $validated['image'] = $imagePath;
            }

            $validated['user_id'] = auth()->id();

            $recipe = Recipe::create($validated);

            return response()->json([
                'message' => 'Recipe added successfully',
                'recipe' => $recipe
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Recipe added failed',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function update(StoreRecipeRequest $request, $id) {

    try {
            $recipe = Recipe::findOrFail($id);

            $validated = $request->validated();

             if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('recipes', 'public');
                $validated['image'] = $imagePath;
            }

            $recipe->update($validated);

            return response()->json([
                'message' => 'Recipe updated successfully',
                'recipe' => $recipe
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Recipe added failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id, $slug){
        try {
            $recipe = Recipe::with([
                'user' => function($q) {
                    $q->withCount('recipes');
                },
                'comments.user',
                'comments.replies.user'
            ])
            ->withCount([
                'reactions as love_reactions_count' => function($q){ $q->where('reaction_type', 'love'); },
                'reactions as fire_reactions_count' => function($q){ $q->where('reaction_type', 'fire'); },
                'reactions as laugh_reactions_count' => function($q){ $q->where('reaction_type', 'laugh'); },
                'reactions as dislike_reactions_count' => function($q){ $q->where('reaction_type', 'dislike'); },
            ])
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

            $user = auth('sanctum')->user();

            $isFavorited = $user
                ? Favorite::where('recipe_id', $recipe->id)
                    ->where('user_id', $user->id)
                    ->exists()
                : false;

            return response()->json([
                'recipe' => $recipe,
                'isFavorited' => $isFavorited
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Recipe not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id) {

        try {
            $recipe = Recipe::findOrFail($id);
            $recipe->delete();

            return response()->json([
                'message' => 'Recipe deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Recipe delete failed',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function fetchMyRecipes(){

        try {
            $myRecipes = Recipe::with('user')
                    ->withCount('comments')
                    ->where('user_id', auth()->id())
                    ->get();

            return response()->json([
                'myRecipes' => $myRecipes
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed fetching my recipes',
                'error' => $e->getMessage()
            ],500);
        }

    }


}
