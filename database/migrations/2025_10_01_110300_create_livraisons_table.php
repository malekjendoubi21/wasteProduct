<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_commande')->constrained('commandes')->onDelete('cascade');
            $table->string('adresse_livraison');
            $table->timestamp('date_livraison')->nullable();
            $table->string('statut')->default('en_attente');
            $table->foreignId('id_trajet')->nullable()->constrained('trajets')->nullOnDelete();
            $table->foreignId('id_utilisateur')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index('statut');
            $table->index('date_livraison');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};
