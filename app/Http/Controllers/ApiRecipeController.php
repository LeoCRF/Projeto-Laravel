<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Recipe;
use App\Models\Comment;

class ApiRecipeController extends Controller
{
    public function show($id)
    {
        // Tenta buscar a receita no banco local
        $recipe = Recipe::find($id);

        if ($recipe) {
            // Prepara os campos com segurança
            $data = [
                'id' => $recipe->id,
                'title' => $recipe->title ?? 'Sem título',
                'image' => $recipe->image ?? null,
                'ingredients' => is_string($recipe->ingredients) 
                                    ? json_decode($recipe->ingredients, true) 
                                    : ($recipe->ingredients ?? []),
                'instructions' => is_string($recipe->instructions) 
                                    ? json_decode($recipe->instructions, true) 
                                    : ($recipe->instructions ?? []),
                'user' => $recipe->user ?? null,
            ];

            $comments = Comment::where('recipe_id', $recipe->id)
                                ->with('user')
                                ->orderBy('created_at', 'desc')
                                ->get();

            return view('recipes.api-show', [
                'recipe' => (object)$data,
                'comments' => $comments
            ]);
        }

        // Se não tiver no banco, tenta buscar na API externa
        $response = Http::get("https://www.themealdb.com/api/json/v1/1/lookup.php?i={$id}");

        if ($response->ok() && isset($response['meals'][0])) {
            $apiRecipe = $response['meals'][0];

            // Montar lista de ingredientes da API
            $ingredients = [];
            for ($i = 1; $i <= 20; $i++) {
                $ingredient = $apiRecipe["strIngredient{$i}"] ?? null;
                $measure = $apiRecipe["strMeasure{$i}"] ?? null;
                if ($ingredient && trim($ingredient) !== '') {
                    $ingredients[] = trim("{$ingredient} - {$measure}");
                }
            }

            $data = [
                'id' => $apiRecipe['idMeal'] ?? $id,
                'title' => $apiRecipe['strMeal'] ?? 'Sem título',
                'image' => $apiRecipe['strMealThumb'] ?? null,
                'ingredients' => $ingredients,
                'instructions' => isset($apiRecipe['strInstructions']) 
                                    ? explode("\n", $apiRecipe['strInstructions']) 
                                    : [],
                'user' => null,
            ];

            $comments = Comment::where('api_recipe_id', $id)
                                ->with('user')
                                ->orderBy('created_at', 'desc')
                                ->get();

            return view('recipes.api-show', [
                'recipe' => (object)$data,
                'comments' => $comments
            ]);
        }

        abort(404, 'Receita não encontrada.');
    }
}
