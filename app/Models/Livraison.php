<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Livraison extends Model
{
    protected $fillable = ['commande_id', 'adresse_livraison', 'date_livraison', 'statut', 'trajet_id', 'user_id'];

    protected $casts = [
        'date_livraison' => 'datetime',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class);
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function taches(): HasMany
    {
        return $this->hasMany(Tache::class);
    }
}
