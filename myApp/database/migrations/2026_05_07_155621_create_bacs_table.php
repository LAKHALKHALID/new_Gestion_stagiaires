<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bacs', function (Blueprint $table) {
            $table->id();
            $table->string('stagiaire_id',20);
            $table->foreign('stagiaire_id')->references('cef')->on('stagiaires')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('cne',20)->unique();
            $table->string('type_retrait',20);
            $table->string('motif');
            $table->string('piece_justification');
            $table->date('date_retrait');
            $table->date('date_retour');
            $table->boolean('is_returned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bacs');
    }
};
