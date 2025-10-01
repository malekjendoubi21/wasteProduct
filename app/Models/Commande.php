<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';

    protected $fillable = [
        'date',
        'montant',
        'id_utilisateur',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'date' => 'datetime',
        'montant' => 'decimal:2',
        'id_utilisateur' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
    ];

    public $timestamps = true;

    // Use business date as created_at like existing models do
    const CREATED_AT = 'date';
    const UPDATED_AT = 'updated_at';

    // Relations
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class, 'id_commande');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
