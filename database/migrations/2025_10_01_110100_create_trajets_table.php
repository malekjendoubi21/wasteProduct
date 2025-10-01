<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->useCurrent();
            $table->string('point_depart');
            $table->string('point_arrivee');
            $table->foreignId('id_vehicule')->constrained('vehicules')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index(['date']);
            $table->index(['id_vehicule']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};
