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
        Schema::create('parts', function (Blueprint $table) {
    $table->id();

    $table->foreignId('equipment_id')->constrained()->cascadeOnDelete();

    $table->string('name');
    $table->integer('quantity')->default(0);
    $table->string('status')->default('Disponible'); // Disponible, Por pedir, Instalado

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
