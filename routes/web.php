<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ApiRecipeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('recipes.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('recipes', RecipeController::class);
    Route::get('/api-recipes/{id}', [ApiRecipeController::class, 'show'])->name('api-recipes.show');
    // provide a safe GET for /comments so redirects to the intended URL (e.g. after login)
    // won't trigger MethodNotAllowed when a POST was attempted while unauthenticated
    Route::get('/comments', function () {
        return redirect()->route('recipes.index');
    })->name('comments.index');
    // rota para postar comentários (exige autenticação)
    Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [\App\Http\Controllers\CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';
