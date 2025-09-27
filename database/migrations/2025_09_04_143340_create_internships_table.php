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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demand_id')->constrained('demandes');
            $table->foreignId('user_id')->constrained('users');
            $table->date('start_date')->required();
            $table->date('end_date')->required();
            $table->string('status')->default('active');
            $table->string('project_name')->nullable();
            $table->string('fiche_fin_stage')->nullable();
            $table->string('evaliation')->nullable();
            $table->date('date_fiche_fin_stage')->nullable();
            $table->date('date_depot_rapport_stage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
