<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contrat extends Model
{
    protected $fillable = ['type_collaboration', 'date_signature', 'user_id'];

    protected $casts = [
        'date_signature' => 'datetime',
    ];

    public function partenaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
