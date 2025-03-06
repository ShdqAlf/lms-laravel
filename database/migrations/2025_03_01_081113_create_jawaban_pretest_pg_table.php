<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_pretest_pg', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pretest_pg_id');
            $table->unsignedBigInteger('user_id'); // siswa
            $table->string('jawaban');
            $table->timestamps();

            $table->foreign('pretest_pg_id')->references('id')->on('pretest_pg')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_pretest_pg');
    }
};
