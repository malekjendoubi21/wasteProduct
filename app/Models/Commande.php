<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    protected $fillable = ['date', 'montant', 'user_id', 'liste_produits'];

    protected $casts = [
        'liste_produits' => 'array',
        'date' => 'datetime',
    ];

    protected $attributes = [
        // Store an empty JSON array by default
        'liste_produits' => '[]',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livraisons(): HasMany
    {
        return $this->hasMany(Livraison::class);
    }
}
