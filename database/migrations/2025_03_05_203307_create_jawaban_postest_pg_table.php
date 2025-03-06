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
        Schema::create('jawaban_postest_pg', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('postest_pg_id');
            $table->unsignedBigInteger('user_id'); // siswa
            $table->text('jawaban');
            $table->timestamps();

            $table->foreign('postest_pg_id')->references('id')->on('postest_pg')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_postest_pg');
    }
};
