<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    // Relación muchos a muchos con Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_restaurant');
    }
}
