<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePptTable extends Migration
{
    public function up()
    {
        Schema::create('ppt', function (Blueprint $table) {
            $table->id();
            $table->string('judul_ppt');
            $table->string('link_ppt');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppt');
    }
}
