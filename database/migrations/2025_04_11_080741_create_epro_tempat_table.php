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
        Schema::create('epro_tempat', function (Blueprint $table) {
            $table->id('tem_id');
            $table->string('tem_keterangan', 200);
            $table->text('tem_alamat');
            $table->text('tem_gmapas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epro_tempat');
    }
};
