<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // Campos asignados
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Casts automáicos
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* -----------------------------------------------------------------
     | Relaciones
     -------------------------------------------------------------------*/

    // Un usuario crea muchos restaurantes  (FK restaurants.user_id)
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    // Un usuario marca muchos restaurantes como favoritos (tabla pivote "favorites")
    public function favorites()
    {
        return $this->belongsToMany(Restaurant::class, 'favorites')
                    ->withTimestamps();
    }

    // Un usuario escribe muchas reseñas  (FK reviews.user_id)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
