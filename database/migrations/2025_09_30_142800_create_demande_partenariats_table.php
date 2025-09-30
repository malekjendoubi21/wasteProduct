<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demande_partenariats', function (Blueprint $table) {
            $table->id();
            $table->string('nom_organisation');
            $table->string('type_organisation');
            $table->string('secteur_activite');
            $table->string('logo')->nullable(); // Champ pour le logo
            $table->string('email_contact');
            $table->string('telephone_contact');
            $table->string('site_web')->nullable();
            $table->string('adresse');
            $table->text('message');
            $table->enum('statut', ['en_attente', 'accepte', 'refuse'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_partenariats');
    }
};
