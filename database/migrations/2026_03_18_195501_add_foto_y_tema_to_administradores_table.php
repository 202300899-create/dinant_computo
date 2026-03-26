<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('administradores', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('password');
            $table->string('tema')->default('claro')->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('administradores', function (Blueprint $table) {
            $table->dropColumn(['foto', 'tema']);
        });
    }
};