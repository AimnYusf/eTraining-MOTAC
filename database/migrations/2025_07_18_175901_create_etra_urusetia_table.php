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
        Schema::create('etra_urusetia', function (Blueprint $table) {
            $table->id('urus_id');
            $table->string('urus_nama');
            $table->string('urus_notel');
            $table->string('urus_emel');
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
