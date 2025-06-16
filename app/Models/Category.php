<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Relación muchos a muchos con Restaurant
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'category_restaurant');
    }
}
