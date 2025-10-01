<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicule extends Model
{
    protected $fillable = ['immatriculation', 'type', 'capacite'];

    public function trajets(): HasMany
    {
        return $this->hasMany(Trajet::class);
    }
}
