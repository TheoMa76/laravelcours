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
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('material_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('material_category_id');
            $table->integer('quantity');
            $table->string('description')->nullable();
            $table->foreignId('project_material_needed_id');
        });

        Schema::create('project_material_neededs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('material_category_id');
            $table->boolean('additional')->default(false);
            $table->foreignId('projet_id');
        });

        Schema::create('money_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('amount');
            $table->string('message')->nullable();
            $table->foreignId('contribution_id');
        });

        Schema::create('volunteer_role_neededs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->foreignId('projet_id');
            $table->string('volunteer_hours_needed');
        });

        Schema::create('volunteer_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('volunteer_hours_amount');
            $table->foreignId('volunteer_role_needed_id');
            //list of days and periods
            //days_list : ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']
            //periods_list : ['Matin', 'Après-midi', 'Soir']
            $table->enum('days_list', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']);
            $table->enum('periods_list', ['Matin', 'Après-midi', 'Soir']);
            $table->string('description')->nullable();
            $table->foreignId('contribution_id');
        });
        Schema::create('contribution_type', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
        });
        Schema::table('projets', function (Blueprint $table) {
            $table->renameColumn('goal', 'money_goal');
            $table->string('volunteer_hour_goal')->after('money_goal')->nullable();
            $table->string('short_description')->after('description')->nullable();
        });
        Schema::table('contributions', function (Blueprint $table) {
            $table->string('approved')->after('description')->default(false);
            $table->string('approved_at')->after('approved');
            $table->foreignId('approved_by_user_id')->after('approved_at')->nullable();
            $table->foreignId('material_details_id')->after('approved_by_user_id')->nullable();
            $table->foreignId('money_details_id')->after('material_details_id')->nullable();
            $table->foreignId('volunteer_details_id')->after('money_details_id')->nullable();
            $table->foreignId('contribution_type_id')->after('volunteer_details_id')->nullable();
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->string('type');
            $table->dropColumn([
                'approved',
                'approved_at',
                'approved_by_user_id',
                'material_details_id',
                'money_details_id',
                'volunteer_details_id',
                'contribution_type_id'
            ]);
        });
    
        Schema::table('projets', function (Blueprint $table) {
            $table->renameColumn('money_goal', 'goal');
            $table->dropColumn(['volunteer_hour_goal', 'short_description']);
        });
    
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    
        Schema::dropIfExists('contribution_type');
        Schema::dropIfExists('volunteer_details');
        Schema::dropIfExists('volunteer_role_needed');
        Schema::dropIfExists('money_details');
        Schema::dropIfExists('project_material_needed');
        Schema::dropIfExists('material_details');
        Schema::dropIfExists('material_category');
    }
};
