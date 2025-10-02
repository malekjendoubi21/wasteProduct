<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Attributs remplissables en masse
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Attributs masqués
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers pour les rôles
    |--------------------------------------------------------------------------
    */

    /**
     * Vérifie si c'est un administrateur
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si c'est un utilisateur "client"
     * (user, employer ou partenaire)
     */
    public function isClient(): bool
    {
        return in_array($this->role, ['user', 'employer', 'partenaire']);
    }

    /**
     * Vérifie si c'est un simple "user"
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Vérifie si c'est un employeur
     */
    public function isEmployer(): bool
    {
        return $this->role === 'employer';
    }

    /**
     * Vérifie si c'est un partenaire
     */
    public function isPartenaire(): bool
    {
        return $this->role === 'partenaire';
    }

    // Nouvelle relation pour les donations
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
