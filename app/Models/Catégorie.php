<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Catégorie extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_creation' => 'datetime',
    ];

    /**
     * Les attributs qui ne doivent pas être sérialisés.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Indique si le modèle doit utiliser les timestamps par défaut.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Le nom de la colonne "created at".
     *
     * @var string
     */
    const CREATED_AT = 'date_creation';

    /**
     * Le nom de la colonne "updated at".
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * Relation avec les produits.
     * Une catégorie peut avoir plusieurs produits.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produits()
    {
        return $this->hasMany(\App\Models\Product::class, 'categorie_id');
    }

    /**
     * Scope pour filtrer par label.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $label
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLabel($query, $label)
    {
        return $query->where('label', 'like', "%{$label}%");
    }

    /**
     * Accesseur pour formater la date de création.
     *
     * @return string
     */
    public function getDateCreationFormatteeAttribute()
    {
        return $this->date_creation ? $this->date_creation->format('d/m/Y H:i') : null;
    }
}