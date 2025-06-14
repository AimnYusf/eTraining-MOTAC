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
        Schema::create('epro_penganjur', function (Blueprint $table) {
            $table->id('pjr_id');
            $table->string('pjr_keterangan', 100);
            $table->string('pjr_noted', 100)->nullable();
            $table->string('pjr_emel', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epro_penganjur');
    }
};
