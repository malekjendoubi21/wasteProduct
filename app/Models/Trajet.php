<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trajet extends Model
{
    protected $fillable = ['date', 'point_depart', 'point_arrivee', 'vehicule_id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function livraisons(): HasMany
    {
        return $this->hasMany(Livraison::class);
    }
}
