<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::query();

        // busca por termo (título, descrição, ingredientes)
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('ingredients', 'like', "%{$q}%");
            });
        }

        // filtrar só as minhas receitas
        if ($request->get('mine') == 1 && Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        // Receitas do banco
        $recipes = $query->latest()->paginate(6)->withQueryString();

        // 🔥 API SEMPRE
        $apiRecipes = Cache::remember('api_recipes_list', 60 * 24, function () {
            try {
                $response = Http::get('https://www.themealdb.com/api/json/v1/1/search.php?s=');

                if ($response->successful() && $response->json()['meals']) {

                    return collect($response->json()['meals'])->map(function ($meal) {

                        $ingredients = collect(range(1, 20))->map(function ($i) use ($meal) {
                            $ingredient = $meal["strIngredient{$i}"] ?? '';
                            $measure = $meal["strMeasure{$i}"] ?? '';
                            return trim($ingredient) ? "{$measure} {$ingredient}" : null;
                        })->filter()->implode(', ');

                        return [
                            'id' => $meal['idMeal'],
                            'title' => $meal['strMeal'], // Mantém em inglês
                            'description' => substr($meal['strInstructions'], 0, 100), // Mantém em inglês
                            'ingredients' => $ingredients,
                            'instructions' => $meal['strInstructions'],
                            'prep_time' => null,
                            'difficulty' => null,
                            'category' => $meal['strCategory'], // Mantém em inglês
                            'sustainability_score' => null,
                            'image' => $meal['strMealThumb'],
                            'user_id' => null,
                        ];
                    })->take(6);
                }

                return collect();
            } catch (\Exception $e) {
                Log::error('Erro ao buscar receitas da API: ' . $e->getMessage());
                return collect();
            }
        });

        return view('recipes.index', compact('recipes', 'apiRecipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'prep_time' => 'nullable|integer|min:0',
            'difficulty' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'sustainability_score' => 'nullable|integer|min:0|max:10',
            'image' => 'nullable|image|max:2048',
        ]);

        $recipe = new Recipe($request->all());
        $recipe->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'public');
            $recipe->image = $path;
        }

        $recipe->save();

        return redirect()->route('recipes.index')->with('success', 'Receita criada com sucesso!');
    }

    public function show(Recipe $recipe)
    {
        $comments = $recipe->comments()->latest()->get();

        $recommended = Recipe::where('category', $recipe->category)
            ->where('id', '!=', $recipe->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('recipes.show', compact('recipe', 'comments', 'recommended'));
    }

    public function edit(Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id) {
            abort(403, 'Você não tem permissão para editar esta receita.');
        }
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id) {
            abort(403, 'Você não tem permissão para editar esta receita.');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'prep_time' => 'nullable|integer|min:0',
            'difficulty' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'sustainability_score' => 'nullable|integer|min:0|max:10',
            'image' => 'nullable|image|max:2048',
        ]);

        $recipe->fill($request->except('image'));

        if ($request->hasFile('image')) {
            if ($recipe->image && Storage::disk('public')->exists($recipe->image)) {
                Storage::disk('public')->delete($recipe->image);
            }

            $path = $request->file('image')->store('recipes', 'public');
            $recipe->image = $path;
        }

        $recipe->save();

        return redirect()->route('recipes.index')->with('success', 'Receita atualizada com sucesso!');
    }

    public function destroy(Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id) {
            abort(403, 'Você não tem permissão para excluir esta receita.');
        }

        if ($recipe->image && Storage::disk('public')->exists($recipe->image)) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Receita deletada com sucesso!');
    }
}
