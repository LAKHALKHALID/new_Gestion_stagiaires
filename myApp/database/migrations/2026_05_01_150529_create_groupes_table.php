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
        Schema::create('groupes', function (Blueprint $table) {
            $table->string('code_g')->primary(); // PK
            $table->string('filiere_id');
            $table->foreign('filiere_id')->references('code_f')->on('filieres')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nom_g');
            $table->text('desc')->nullable();
            $table->integer('capacite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
