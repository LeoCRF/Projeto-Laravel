<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Comment;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ApiRecipeController extends Controller
{
    public function show($id)
    {
        try {
            // Verificar se está em cache primeiro
            $cacheKey = "api_recipe_{$id}";
            $recipe = Cache::remember($cacheKey, 60 * 24, function () use ($id) {
                return $this->fetchAndTranslateRecipe($id);
            });

            if (!$recipe) {
                abort(404, 'Receita não encontrada');
            }

            $comments = Comment::where('api_recipe_id', $id)->latest()->get();
            
            // Buscar receitas recomendadas: mesma categoria do banco local
            $recommended = \App\Models\Recipe::where('category', $recipe['category'])
                ->latest()
                ->limit(4)
                ->get();
            
            return view('recipes.api-show', compact('recipe', 'comments', 'recommended'));
        } catch (\Exception $e) {
            abort(500, 'Erro ao buscar receita: ' . $e->getMessage());
        }
    }

    private function fetchAndTranslateRecipe($id)
    {
        $response = Http::get("https://www.themealdb.com/api/json/v1/1/lookup.php?i={$id}");
        $meal = $response->json()['meals'][0] ?? null;

        if (!$meal) {
            return null;
        }

        // Traduzir os dados
        $translate = new GoogleTranslate('pt');
        
        try {
            $title = $translate->translate($meal['strMeal']);
            $description = $translate->translate(substr($meal['strInstructions'], 0, 150));
            $category = $translate->translate($meal['strCategory']);
            $instructions = $translate->translate($meal['strInstructions']);
        } catch (\Exception $e) {
            // Se falhar, usar original
            $title = $meal['strMeal'];
            $description = substr($meal['strInstructions'], 0, 150);
            $category = $meal['strCategory'];
            $instructions = $meal['strInstructions'];
        }

        // Traduzir ingredientes
        $ingredients = collect(range(1, 20))->map(function ($i) use ($meal, $translate) {
            $ingredient = $meal["strIngredient{$i}"] ?? '';
            $measure = $meal["strMeasure{$i}"] ?? '';
            
            if (trim($ingredient)) {
                try {
                    $translatedIngredient = $translate->translate($ingredient);
                } catch (\Exception $e) {
                    $translatedIngredient = $ingredient;
                }
                return "{$measure} {$translatedIngredient}";
            }
            return null;
        })->filter()->values();

        return [
            'id' => $meal['idMeal'],
            'title' => $title,
            'description' => $description,
            'ingredients' => $ingredients,
            'instructions' => $instructions,
            'category' => $category,
            'image' => $meal['strMealThumb'],
            'tags' => $meal['strTags'] ? explode(',', $meal['strTags']) : [],
            'youtube' => $meal['strYoutube'] ?? null,
        ];
    }
}