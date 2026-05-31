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
        Schema::create('deperditions', function (Blueprint $table) {
            $table->id();
            $table->string('stagiaire_id',20);
            $table->foreign('stagiaire_id')->references('cef')->on('stagiaires')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('raison_deperdition',20);
            $table->string('raison_retour', 20)->nullable();
            $table->date('date_deperdition');
            $table->date('date_retour')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deperditions');
    }
};
