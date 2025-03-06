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
        Schema::table('jawaban_lkpd', function (Blueprint $table) {
            $table->string('gambar_jawaban')->nullable()->after('jawaban'); // Menyimpan path gambar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_lkpd', function (Blueprint $table) {
            $table->dropColumn('gambar_jawaban');
        });
    }
};
