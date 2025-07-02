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
        Schema::create('epro_kehadiran', function (Blueprint $table) {
            $table->id('keh_id');
            $table->foreignId('keh_idusers')->constrained('users');
            $table->foreignId('keh_idkursus')->constrained('epro_kursus', 'kur_id');
            $table->date('keh_tkhmasuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epro_kehadiran');
    }
};
