<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Restaurant extends Model
{
    // Campos que se pueden asignar con create() / update()
    protected $fillable = ['name', 'description', 'address', 'user_id'];

    /* -----------------------------------------------------------------
     | Relaciones
     |------------------------------------------------------------------*/

    // Pertenece a un usuario (FK restaurants.user_id → users.id)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Muchos‑a‑muchos con categorías via tabla pivote "category_restaurant"
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_restaurant')
                    ->withTimestamps();
    }

    // Un restaurante tiene muchas reseñas
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Un restaurante tiene muchas fotos
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    // Usuarios que lo han marcado como favorito
    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites')
                    ->withTimestamps();
    }

    /* -----------------------------------------------------------------
     | Scopes
     |------------------------------------------------------------------*/

    /**
     * scopeActive => Restaurant::active()->get()
     * Filtra restaurantes con un hipotético campo status = 'active'.
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    /* -----------------------------------------------------------------
     | Accessors / Mutators
     |------------------------------------------------------------------*/

    /**
     * getNameAttribute
     * Devuelve el nombre capitalizado cada vez que se accede: $restaurant->name
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
