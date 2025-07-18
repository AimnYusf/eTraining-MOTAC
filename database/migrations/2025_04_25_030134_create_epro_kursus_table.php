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
        Schema::create('epro_kursus', function (Blueprint $table) {
            $table->id('kur_id'); // Auto-incrementing primary key
            $table->string('kur_nama', 200)->nullable();
            $table->text('kur_objektif')->nullable();
            $table->foreignId('kur_idkategori')->nullable()->constrained('epro_kategori', 'kat_id')->onDelete('cascade');
            $table->date('kur_tkhmula')->nullable();
            $table->string('kur_msamula', 100)->nullable();
            $table->date('kur_tkhtamat')->nullable();
            $table->string('kur_msatamat', 100)->nullable();
            $table->integer('kur_bilhari')->nullable();
            $table->foreignId('kur_idtempat')->nullable()->constrained('epro_tempat', 'tem_id')->onDelete('cascade');
            $table->date('kur_tkhbuka')->nullable();
            $table->date('kur_tkhtutup')->nullable();
            $table->integer('kur_bilpeserta')->nullable();
            $table->foreignId('kur_idkumpulan')->nullable()->constrained('epro_kumpulan', 'kum_id')->onDelete('cascade');
            $table->foreignId('kur_idpenganjur')->nullable()->constrained('epro_penganjur', 'pjr_id')->onDelete('cascade');
            $table->json('kur_urusetia')->nullable();
            $table->string('kur_poster')->nullable();
            $table->integer('kur_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epro_kursus');
    }
};
