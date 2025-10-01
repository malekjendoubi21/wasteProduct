<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Categorie extends Model
{
    protected $fillable = ['libelle', 'image', 'date_creation'];

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}
