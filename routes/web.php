<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ApiRecipeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redireciona a raiz para receitas
Route::get('/', function () {
    return redirect()->route('recipes.index');
});

// Dashboard protegido
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas públicas
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index'); // Lista de receitas pública
Route::get('/api-recipes/{id}', [ApiRecipeController::class, 'show'])->name('api-recipes.show'); // Detalhes API pública

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {

    // CRUD de receitas protegido (incluindo create)
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comentários
    Route::get('/comments', function () {
        return redirect()->route('recipes.index');
    })->name('comments.index');
    Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [\App\Http\Controllers\CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});

// Rotas públicas de receitas individuais devem vir **depois** do create
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

require __DIR__.'/auth.php';
