<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceProduit extends Model
{
    protected $fillable = ['produit_id', 'description'];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
