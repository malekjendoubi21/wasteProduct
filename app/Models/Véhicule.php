<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Véhicule extends Model
{
    use HasFactory;

    protected $table = 'vehicules';

    protected $fillable = [
        'immatriculation',
        'type',
        'capacite',
    ];

    protected $casts = [
        'capacite' => 'integer',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'id_vehicule');
    }
}
