<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_pretest', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pretest_id');
            $table->unsignedBigInteger('user_id'); // siswa
            $table->text('jawaban');
            $table->timestamps();

            $table->foreign('pretest_id')->references('id')->on('pretest')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_pretest');
    }
};
