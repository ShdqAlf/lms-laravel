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
        // Membuat tabel kelompok
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok'); // Nama kelompok
            $table->timestamps();
        });

        // Menambahkan kolom kelompok_id dan is_ketua pada tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kelompok_id')->nullable()->constrained('kelompok')->onDelete('set null'); // Relasi ke tabel kelompok
            $table->boolean('is_ketua')->default(false); // Menandakan apakah pengguna adalah ketua kelompok
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom dan relasi
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelompok_id']);
            $table->dropColumn(['kelompok_id', 'is_ketua']);
        });

        // Menghapus tabel kelompok
        Schema::dropIfExists('kelompok');
    }
};
