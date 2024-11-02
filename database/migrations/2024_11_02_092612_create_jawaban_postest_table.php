<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_postest', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('postest_id');
            $table->unsignedBigInteger('user_id'); // siswa
            $table->text('jawaban');
            $table->timestamps();

            $table->foreign('postest_id')->references('id')->on('postest')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_postest');
    }
};
