<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $table = 'livraisons';

    protected $fillable = [
        'id_commande',
        'adresse_livraison',
        'date_livraison',
        'statut',
        'id_trajet',
        'id_utilisateur', // employé, nullable
    ];

    protected $casts = [
        'id_commande' => 'integer',
        'date_livraison' => 'datetime',
        'id_trajet' => 'integer',
        'id_utilisateur' => 'integer',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Relations
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }

    public function trajet()
    {
        return $this->belongsTo(Trajet::class, 'id_trajet');
    }

    public function employe()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
}
