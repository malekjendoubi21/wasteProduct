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

    /*
    |--------------------------------------------------------------------------
    | Relations (UML)
    |--------------------------------------------------------------------------
    */

    // Commandes passées par l'utilisateur
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    // Donations effectuées par l'utilisateur
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // Participation aux événements
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    // Un seul panier par utilisateur
    public function panier()
    {
        return $this->hasOne(Panier::class);
    }

    // Contrats (rôle = partenaire)
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    // Tâches (rôle = employé)
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    // Produits publiés par un partenaire
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    // Événements créés par un partenaire (nullable)
    public function evenements()
    {
        return $this->hasMany(Evenement::class);
    }

    // Livraisons affectées à un employé (nullable)
    public function livraisons()
    {
        return $this->hasMany(Livraison::class);
    }
}
