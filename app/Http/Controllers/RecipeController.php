<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index() {

        try {
            $recipes = Recipe::with('user')
                ->withCount('comments')
                ->latest()    
                ->paginate(24);

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
    
    public function show($id){
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
            ->findOrFail($id);
            
            return response()->json([
                'recipe' => $recipe
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Recipe not found',
                'error' => $e->getMessage()
            ], 404);
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
