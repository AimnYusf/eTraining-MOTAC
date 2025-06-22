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
        Schema::create('epro_isytihar', function (Blueprint $table) {
            $table->id('isy_id');
            $table->foreignId('isy_idusers')->constrained('users')->onDelete('cascade');
            $table->string('isy_nama');
            $table->date('isy_tkhmula');
            $table->date('isy_tkhtamat');
            $table->string('isy_jam')->nullable();
            $table->string('isy_tempat');
            $table->string('isy_anjuran');
            $table->string('isy_kos');
            $table->foreignId('isy_status')->constrained('epro_status', 'stp_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epro_isytihar');
    }
};
