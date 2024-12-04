<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->string('course_code');
            $table->integer('semester');
            $table->integer('year');
            $table->json('course_codes');             
            $table->integer('total_credit_hour')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('matric_no')->nullable(); $table->foreign('matric_no')->references('matric_no')->on('profiles')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_schedules');
    }
};
