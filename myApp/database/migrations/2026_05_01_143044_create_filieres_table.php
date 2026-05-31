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
        Schema::create('filieres', function (Blueprint $table) {
            $table->string('code_f')->primary(); // PK
            // $table->string('niveau',40);
            $table->text('desc')->nullable();
            $table->string('secteur')->nullable();
            $table->string('mode_formation', 30);
            $table->string('nom_filiere_francais',100);
            $table->string('nom_filiere_arabe',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};
