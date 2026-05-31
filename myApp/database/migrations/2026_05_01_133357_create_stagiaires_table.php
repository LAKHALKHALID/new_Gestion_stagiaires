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
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->string('cef',20)->primary();
            $table->string('cin',10)->unique();
            $table->string('nom_francais',30);
            $table->string('prenom_francais',30);
            $table->string('nom_arabe', 30);
            $table->string('prenom_arabe', 30);
            $table->string('nom_annee_scolaire',10);
            $table->date('date_naissance');
            $table->string('lieu_naissance',30);
            $table->string('niveau_formation', 40);
            $table->string('type_formation', 30);
            $table->string('annee_etude', 30);
            $table->date('date_demarrage_formation');
            $table->string('tel', 20);
            $table->integer('note')->default(20);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
