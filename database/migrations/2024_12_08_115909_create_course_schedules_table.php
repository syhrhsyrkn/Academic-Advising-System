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
            $table->string('matric_no'); 
            $table->foreign('matric_no')->references('matric_no')->on('profiles')->onDelete('cascade');
            
            // Adding semester_number and academic_year directly to the course_schedules table
            $table->integer('semester_number'); // 1, 2, 3
            $table->string('academic_year'); // Year 1, Year 2, etc.

            $table->string('course_code'); 
            $table->foreign('course_code')->references('course_code')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_schedules');
    }
}

