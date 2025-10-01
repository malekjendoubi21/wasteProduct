<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Produit extends Model
{
    protected $fillable = [
        'nom',
        'description',
    'image',
        'stock',
        'prix_base',
        'type',
        'categorie_id',
        'user_id',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function partenaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function annonce(): HasOne
    {
        return $this->hasOne(AnnonceProduit::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}
