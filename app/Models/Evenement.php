<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evenement extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'lieu',
        'image',
        'created_by',
        'status'
    ];

    // Relation avec l'utilisateur qui a créé l'événement
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }

}
