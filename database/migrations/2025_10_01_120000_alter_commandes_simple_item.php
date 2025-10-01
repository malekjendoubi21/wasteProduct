<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'liste_produits')) {
                $table->dropColumn('liste_produits');
            }
            $table->foreignId('product_id')->after('id_utilisateur')->constrained('products')->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('commandes', 'quantity')) {
                $table->dropColumn('quantity');
            }
            $table->json('liste_produits')->nullable();
        });
    }
};
