<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    use HasFactory;

    protected $table = 'trajets';

    protected $fillable = [
        'date',
        'point_depart',
        'point_arrivee',
        'id_vehicule',
    ];

    protected $casts = [
        'date' => 'datetime',
    'id_vehicule' => 'integer',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function vehicule()
    {
        return $this->belongsTo(Véhicule::class, 'id_vehicule');
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class, 'id_trajet');
    }
}
