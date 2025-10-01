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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('prix_base', 10, 2);
            $table->enum('type', ['recycle', 'non_recycle']);
            $table->unsignedBigInteger('categorie_id')->index(); // FK added in a later migration
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // partenaire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
