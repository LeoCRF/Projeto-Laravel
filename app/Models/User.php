<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Importações necessárias
use App\Models\Recipe;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read Collection|Recipe[] $recipes
 * @property-read Collection|Recipe[] $likes
 * @property-read Collection|Recipe[] $saved_recipes
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Receitas criadas pelo usuário (1 para muitos).
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Comentários escritos pelo usuário.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Receitas curtidas pelo usuário (many-to-many).
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_user_likes')->withTimestamps();
    }

    /**
     * Receitas salvas pelo usuário (many-to-many).
     */
    public function saved_recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_user_saves')->withTimestamps();
    }
}
