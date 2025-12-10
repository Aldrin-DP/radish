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
                'reactions', 
                'comments.user',
                'comments.replies.user'
            ])->findOrFail($id);
            
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


}
