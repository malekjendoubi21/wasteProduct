<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Donation extends Model
{const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'association_id',
        'description',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function items()
    {
        return $this->hasMany(DonationItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            self::STATUS_PENDING => 'En attente',
            self::STATUS_ACCEPTED => 'Acceptée',
            self::STATUS_DELIVERED => 'Livré',
            self::STATUS_CANCELLED => 'Annulée',
        ][$this->status] ?? 'Inconnu';
    }

    public function getFormattedDateAttribute()
    {
        return $this->date ? Carbon::parse($this->date)->format('d/m/Y') : null;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAssociation($query, $associationId)
    {
        return $query->where('association_id', $associationId);
    }
}
