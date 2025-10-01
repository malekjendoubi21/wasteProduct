<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PanierProduit extends Model
{
    protected $fillable = ['panier_id', 'produit_id', 'quantite'];

    public function panier(): BelongsTo
    {
        return $this->belongsTo(Panier::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
