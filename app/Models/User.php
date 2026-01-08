<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'role',
        'permissions',
        'avatar',
        'bio',
        'website',
        'twitter',
        'facebook',
        'instagram',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array', // Esto convierte el JSON de la DB en un Array de PHP automáticamente
        ];
    }

    /**
     * MÉTODOS DE AYUDA (Para no repetir in_array en todo el proyecto)
     */
    public function hasPermission(string $permission): bool
    {
        // El Administrador siempre tiene permiso para todo
        if ($this->role === 'admin') {
            return true;
        }

        // Para los demás, comprobamos el array de la columna 'permissions'
        return in_array($permission, $this->permissions ?? []);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
