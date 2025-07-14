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
        Schema::create('epro_pengguna', function (Blueprint $table) {
            $table->id('pen_id');
            $table->foreignId('pen_idusers')->constrained('users')->onDelete('cascade');
            $table->string('pen_nama', 200);
            $table->string('pen_nokp', 12)->nullable();
            $table->integer('pen_jantina')->nullable();
            $table->string('pen_emel', 200);
            $table->string('pen_notel', 100)->nullable();
            $table->string('pen_nohp', 100)->nullable();
            $table->string('pen_nofaks', 100)->nullable();
            $table->foreignId('pen_idbahagian')->nullable()->constrained('epro_bahagian', 'bah_id');
            $table->string('pen_jawatan', 200)->nullable();
            $table->string('pen_gred', 100)->nullable();
            $table->integer('pen_idkumpulan')->nullable()->constrained('epro_kumpulan', 'kum_id');
            $table->string('pen_jabatanlain', 200)->nullable();
            $table->integer('pen_idjabatan')->nullable()->constrained('epro_jabatan', 'jab_id');
            $table->string('pen_ppnama')->nullable();
            $table->string('pen_ppemel')->nullable();
            $table->string('pen_ppgred')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epro_pengguna');
    }
};
