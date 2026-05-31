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
        Schema::create('stagiaire_groupe', function (Blueprint $table) {
            $table->string('groupe_id');
            $table->string('stagiaire_id', 20);
            $table->foreign('groupe_id')->references('code_g')->on('groupes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('stagiaire_id')->references('cef')->on('stagiaires')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['groupe_id', 'stagiaire_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagiaire_groupe');
    }
};
