<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computadora_usuario', function (Blueprint $table) {
            $table->unsignedInteger('computadora_id');
            $table->unsignedInteger('usuario_id');

            $table->primary(['computadora_id', 'usuario_id']);

            $table->foreign('computadora_id')
                ->references('id')
                ->on('computadoras')
                ->onDelete('cascade');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computadora_usuario');
    }
};