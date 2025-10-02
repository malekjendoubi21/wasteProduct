<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class DemandePartenariat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_organisation',
        'type_organisation',
        'secteur_activite',
        'logo',
        'email_contact',
        'telephone_contact',
        'site_web',
        'adresse',
        'message',
        'statut',
    ];

    /**
     * Obtenir l'URL du logo
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            // Image par défaut si pas de logo
            return asset('images/carr.png'); // Utilise l'image existante comme défaut
        }

        // Si le logo est juste un nom de fichier, on le cherche dans images/
        if (!str_contains($this->logo, '/')) {
            return asset('images/' . $this->logo);
        }

        // Si le logo a un chemin, vérifier s'il existe dans storage
        if (Storage::disk('public')->exists($this->logo)) {
            return asset('storage/' . $this->logo);
        }

        // Fallback vers l'image par défaut
        return asset('images/carr.png');
    }

    /**
     * Scope pour les partenaires acceptés
     */
    public function scopeAccepte($query)
    {
        return $query->where('statut', 'accepte');
    }

    /**
     * Scope pour les partenaires avec logo
     */
    public function scopeAvecLogo($query)
    {
        return $query->whereNotNull('logo');
    }
}
