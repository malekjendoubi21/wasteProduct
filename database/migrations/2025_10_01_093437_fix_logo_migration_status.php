<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Marquer la migration problématique comme exécutée
        DB::table('migrations')->insert([
            'migration' => '2025_09_30_162217_add_logo_to_demande_partenariats_table',
            'batch' => 3
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer l'entrée de la table des migrations
        DB::table('migrations')
            ->where('migration', '2025_09_30_162217_add_logo_to_demande_partenariats_table')
            ->delete();
    }
};
