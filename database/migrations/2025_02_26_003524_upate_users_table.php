<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Menambahkan kolom course_opened dan materi_opened pada tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->integer('course_opened')->default(0); // Kolom untuk menyimpan informasi tentang course yang telah dibuka
            $table->integer('materi_opened')->default(0); // Kolom untuk menyimpan informasi tentang materi yang telah dibuka
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom course_opened dan materi_opened
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['course_opened', 'materi_opened']);
        });
    }
};
