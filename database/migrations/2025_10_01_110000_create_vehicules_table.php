<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('immatriculation')->unique();
            $table->string('type');
            $table->integer('capacite');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index(['type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
