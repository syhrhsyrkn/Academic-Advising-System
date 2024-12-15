<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('student_course_schedule', function (Blueprint $table) {
            // Foreign key to students table, referencing student_id
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade');

            // Course code as string
            $table->string('course_code');

            // Foreign key to semesters table, referencing semester_id
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');

            // Composite primary key on student_id, course_code, and semester_id
            $table->primary(['student_id', 'course_code', 'semester_id']);

            // Foreign key for course_code referencing the courses table
            $table->foreign('course_code')->references('course_code')->on('courses')->onDelete('cascade');

            // Optional: add unique constraint for the combination of student_id and course_code
            // This will prevent duplicates if not using a composite primary key
            $table->unique(['student_id', 'course_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_course_schedule');
    }
}
