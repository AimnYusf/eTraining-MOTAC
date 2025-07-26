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
        Schema::create('etra_urusetia', function (Blueprint $table) {
            $table->id('pic_id');
            $table->string('pic_nama');
            $table->string('pic_emel');
            $table->string('pic_notel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etra_urusetia');
    }
};
