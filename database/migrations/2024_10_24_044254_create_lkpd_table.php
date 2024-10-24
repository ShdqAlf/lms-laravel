<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkpdTable extends Migration
{
    public function up()
    {
        Schema::create('lkpd', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi_lkpd');
            $table->string('pdf_lkpd');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lkpd');
    }
}
