<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Membuat tabel courses untuk menyimpan mata pelajaran
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course'); // Menyimpan nama mata pelajaran
            $table->timestamps();
        });

        // Mengubah tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_id')->unique();
            $table->string('password');
            $table->enum('role', ['guru', 'siswa', 'admin']);
            // Mengganti mata_pelajaran dengan course_id yang nullable
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('courses'); // Drop tabel courses
    }
};
