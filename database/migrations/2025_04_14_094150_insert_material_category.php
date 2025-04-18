<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('material_categories')->insert([
            [
                'name' => 'Outils',
                'description' => 'Catégorie dédiée aux personnes souhaitant faire don d’outils utiles aux projets écologiques, qu’il s’agisse d’outillage de jardin, de bricolage ou de construction.',
                'created_at' => now(),
            ],
            [
                'name' => 'Matériaux de construction',
                'description' => 'Catégorie destinée aux dons de matériaux de construction pour soutenir les projets écologiques locaux, comme le bois, la pierre, ou encore des matériaux recyclés.',
                'created_at' => now(),
            ],
            [
                'name' => 'Plantes et végétaux',
                'description' => 'Pour les dons de plantes, graines ou végétaux destinés à être plantés ou utilisés dans des projets de décoration végétale en lien avec la nature.',
                'created_at' => now(),
            ],
            [
                'name' => 'Peinture et décoration',
                'description' => 'Catégorie pour les dons d’éléments de décoration ou de peinture, utiles pour embellir des projets écologiques tout en favorisant le réemploi et la créativité durable.',
                'created_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('material_categories')->whereIn('name', [
            'Outils',
            'Matériaux de construction',
            'Plantes et végétaux',
            'Peinture et décoration',
        ])->delete();
    }
};

