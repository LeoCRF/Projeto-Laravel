<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RecipeController extends Controller
{
    
    public function index()
    {
        $recipes = Recipe::latest()->paginate(6);
        return view('recipes.index', compact('recipes'));
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
        return view('recipes.show', compact('recipe'));
    }

    
    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    
    public function update(Request $request, Recipe $recipe)
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
        if ($recipe->image && Storage::disk('public')->exists($recipe->image)) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Receita deletada com sucesso!');
    }
}
