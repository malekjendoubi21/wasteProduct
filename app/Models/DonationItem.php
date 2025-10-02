<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    /** @use HasFactory<\Database\Factories\DonationItemFactory> */
    use HasFactory;
    protected $fillable = [
        'donation_id',
        'product_id',
        'quantity',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
