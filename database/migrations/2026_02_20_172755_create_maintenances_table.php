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
      Schema::create('maintenances', function (Blueprint $table) {
    $table->id();

    $table->foreignId('equipment_id')->constrained()->cascadeOnDelete();

    $table->date('maintenance_date');
    $table->string('type'); // Preventivo, Correctivo
    $table->text('description')->nullable();
    $table->string('status')->default('Pendiente');
    $table->string('image')->nullable();

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
