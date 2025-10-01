<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Les types de produits disponibles.
     */
    const TYPE_RECYCLE = 'recyclé';
    const TYPE_ALIMENTAIRE = 'alimentaire';
    const TYPE_NON_RECYCLE = 'non_recyclé';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'description',
        'prix_base',
        'stock',
        'type',
        'image',
        'categorie_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'prix_base' => 'decimal:2',
        'stock' => 'integer',
        'date_ajout' => 'datetime',
        'categorie_id' => 'integer',
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
    const CREATED_AT = 'date_ajout';

    /**
     * Le nom de la colonne "updated at".
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * Relation avec la catégorie.
     * Un produit appartient à une catégorie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie()
    {
        return $this->belongsTo(\App\Models\Catégorie::class, 'categorie_id');
    }

    /**
     * Scope pour filtrer par type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope pour les produits en stock.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope pour filtrer par catégorie.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $categorieId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategorie($query, $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    /**
     * Scope pour rechercher par nom.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $nom
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByNom($query, $nom)
    {
        return $query->where('nom', 'like', "%{$nom}%");
    }

    /**
     * Accesseur pour formater le prix.
     *
     * @return string
     */
    public function getPrixFormatteAttribute()
    {
        return number_format($this->prix_base, 2, ',', ' ') . ' €';
    }

    /**
     * Accesseur pour formater la date d'ajout.
     *
     * @return string
     */
    public function getDateAjoutFormatteeAttribute()
    {
        return $this->date_ajout ? $this->date_ajout->format('d/m/Y H:i') : null;
    }

    /**
     * Accesseur pour l'URL de l'image.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Mutateur pour le type.
     *
     * @param string $value
     * @return void
     */
    public function setTypeAttribute($value)
    {
        $types = [self::TYPE_RECYCLE, self::TYPE_ALIMENTAIRE, self::TYPE_NON_RECYCLE];
        
        if (in_array($value, $types)) {
            $this->attributes['type'] = $value;
        } else {
            throw new \InvalidArgumentException("Type invalide: {$value}");
        }
    }

    /**
     * Vérifier si le produit est en stock.
     *
     * @return bool
     */
    public function estEnStock()
    {
        return $this->stock > 0;
    }

    /**
     * Obtenir tous les types disponibles.
     *
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_RECYCLE => 'Recyclé',
            self::TYPE_ALIMENTAIRE => 'Alimentaire',
            self::TYPE_NON_RECYCLE => 'Non recyclé',
        ];
    }
}