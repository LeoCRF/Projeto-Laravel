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
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show'); // Detalhes públicos
Route::get('/api-recipes/{id}', [ApiRecipeController::class, 'show'])->name('api-recipes.show'); // Detalhes API pública

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de receitas, exceto 'show' e 'index'
    Route::resource('recipes', RecipeController::class)->except(['index', 'show']);

    // Comentários
    Route::get('/comments', function () {
        return redirect()->route('recipes.index');
    })->name('comments.index');

    Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [\App\Http\Controllers\CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';
