<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandePartenariat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_organisation',
        'type_organisation',
        'secteur_activite',
        'logo',
        'email_contact',
        'telephone_contact',
        'site_web',
        'adresse',
        'message',
        'statut',
    ];
}
