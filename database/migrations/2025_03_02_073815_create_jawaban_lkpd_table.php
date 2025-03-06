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
        Schema::create('jawaban_lkpd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lkpd_kelompok_id');
            $table->unsignedBigInteger('user_id'); // siswa
            $table->text('jawaban');
            $table->timestamps();

            $table->foreign('lkpd_kelompok_id')->references('id')->on('lkpd_kelompok')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_lkpd');
    }
};
