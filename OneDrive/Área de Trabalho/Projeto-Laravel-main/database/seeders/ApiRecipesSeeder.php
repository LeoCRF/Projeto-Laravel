<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Comment;
use Illuminate\Support\Facades\Http;

class ApiRecipeController extends Controller
{
    public function show($id)
    {
        // Tenta buscar a receita no banco local primeiro
        $recipe = Recipe::with('comments.user')->find($id);
        $comments = collect();

        if ($recipe) {
            // Padroniza os campos para a view, como se fosse da API
            $recipeObj = (object)[
                'idMeal' => $recipe->id,
                'strMeal' => $recipe->title,
                'strInstructions' => $recipe->instructions,
                'strMealThumb' => $recipe->image,           // Mapeia imagem
                'strCategory' => $recipe->category,
                'strYoutube' => $recipe->youtube ?? null,   // Caso exista
                // Transformando JSON de ingredientes em array
                'ingredients' => $recipe->ingredients ? json_decode($recipe->ingredients, true) : [],
            ];

            $comments = $recipe->comments;
        } else {
            // Caso não esteja no banco, busca na API externa
            $response = Http::get("https://www.themealdb.com/api/json/v1/1/lookup.php?i={$id}");
            $data = $response->json();

            if (!empty($data['meals'][0])) {
                $meal = $data['meals'][0];
                $recipeObj = (object) $meal;
            } else {
                abort(404, 'Receita não encontrada.');
            }
        }

        // Receitas recomendadas (exemplo: busca outras 4 aleatórias da API)
        $recommendedResp = Http::get("https://www.themealdb.com/api/json/v1/1/random.php");
        $recommended = collect($recommendedResp->json()['meals'] ?? []);

        return view('recipes.api-show', [
            'recipe' => $recipeObj,
            'comments' => $comments,
            'recommended' => $recommended
        ]);
    }
}
