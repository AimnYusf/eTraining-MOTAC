<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('epro_permohonan', function (Blueprint $table) {
            $table->id('per_id');
            $table->foreignId('per_idusers')->constrained('users')->onDelete('cascade');
            $table->foreignId('per_idkursus')->constrained('etra_kursus', 'kur_id')->onDelete('cascade');
            $table->date('per_tkhmohon')->nullable();
            $table->date('per_tkhtindakan')->nullable();
            $table->string('per_pengangkutan')->nullable();
            $table->string('per_makanan')->nullable();
            $table->foreignId('per_status')->constrained('etra_status', 'stp_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epro_permohonan');
    }
};
