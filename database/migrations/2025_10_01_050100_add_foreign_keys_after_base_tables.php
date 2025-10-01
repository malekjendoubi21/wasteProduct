<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->foreign('categorie_id')->references('id')->on('categories')->cascadeOnDelete();
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('association_id')->references('id')->on('associations')->cascadeOnDelete();
        });

        Schema::table('taches', function (Blueprint $table) {
            $table->foreign('livraison_id')->references('id')->on('livraisons')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['association_id']);
        });

        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign(['livraison_id']);
        });
    }
};
