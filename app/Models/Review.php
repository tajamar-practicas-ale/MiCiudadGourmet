<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'restaurant_id', 'rating', 'comment'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Una reseña pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una reseña pertenece a un restaurante
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
