<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->useCurrent();
            $table->decimal('montant', 10, 2);
            $table->foreignId('id_utilisateur')->constrained('users')->onDelete('cascade');
            $table->json('liste_produits');
            $table->timestamp('updated_at')->nullable();

            $table->index('id_utilisateur');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
