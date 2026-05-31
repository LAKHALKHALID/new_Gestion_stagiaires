<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->string('stagiaire_id',20);
            $table->foreign('stagiaire_id')->references('cef')->on('stagiaires')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status',20)->default('present');
            $table->string('seance',100);
            $table->string('justification')->nullable();
            $table->string('chemin')->nullable();
            $table->string('medecin')->nullable();
            $table->date('date')->default(now());
            $table->date('startWeek')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
