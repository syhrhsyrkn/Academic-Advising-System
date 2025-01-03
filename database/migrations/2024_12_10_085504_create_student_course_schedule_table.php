<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('student_course_schedule', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade');
            $table->string('course_code');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->primary(['student_id', 'course_code', 'semester_id']);
            $table->foreign('course_code')->references('course_code')->on('courses')->onDelete('cascade');
            $table->unique(['student_id', 'course_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_course_schedule');
    }
}
