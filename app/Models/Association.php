<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{      use HasFactory;

    protected $fillable = [
        'name',
        'contact_email',
        'contact_phone',
        'domain',
        'address',
        'description',
        'status',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
