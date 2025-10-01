<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evenement extends Model
{
    protected $fillable = ['nom', 'description', 'date', 'lieu', 'user_id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function partenaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }
}
