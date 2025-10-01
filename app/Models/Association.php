<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Association extends Model
{
    protected $fillable = ['nom', 'contact', 'domaine'];

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }
}
