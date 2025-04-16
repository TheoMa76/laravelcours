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
        DB::table('contribution_types')->insert([
            [
                'name' => 'financial',
                'description' => 'Pour les dons financiers destinés à soutenir les projets écologiques locaux.',
                'created_at' => now(),
            ],
            [
                'name' => 'material',
                'description' => 'Pour les dons de matériaux destinés à soutenir les projets écologiques locaux.',
                'created_at' => now(),
            ],
            [
                'name' => 'volunteer',
                'description' => 'Pour les dons de temps et de compétences, permettant de soutenir les projets écologiques locaux.',
                'created_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('contribution_type')->where('name', 'financial')->delete();
        DB::table('contribution_type')->where('name', 'material')->delete();
        DB::table('contribution_type')->where('name', 'volunteer')->delete();
    }
};
