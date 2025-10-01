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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->decimal('prix_base', 10, 2);
            $table->integer('stock')->default(0);
            $table->enum('type', ['recyclé', 'alimentaire', 'non_recyclé']);
            $table->string('image')->nullable();
            $table->timestamp('date_ajout')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Clé étrangère vers la table categories
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            
            // Index pour optimiser les recherches
            $table->index('nom');
            $table->index('type');
            $table->index('categorie_id');
            $table->index('date_ajout');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};