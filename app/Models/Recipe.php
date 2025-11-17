<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'ingredients',
        'instructions',
        'prep_time',
        'difficulty',
        'category',
        'image',
    ];

    // Dono da receita
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Comentários da receita
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Usuários que curtiram a receita
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'recipe_user_likes')->withTimestamps();
    }

    // Usuários que salvaram a receita
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'recipe_user_saves')->withTimestamps();
    }
}
