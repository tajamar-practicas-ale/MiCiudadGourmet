<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // Muchos‑a‑muchos inverso: restaurantes que pertenecen a esta categoría
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'category_restaurant')
                    ->withTimestamps();
    }
}
