<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['restaurant_id', 'url'];

    // Una foto pertenece a un restaurante
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
