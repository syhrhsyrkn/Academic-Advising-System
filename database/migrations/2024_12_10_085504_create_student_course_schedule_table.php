<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('student_course_schedule', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade'); // foreign key to students table, references student_id
            
            $table->string('course_code'); // course_code as string
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade'); // foreign key to semesters table
            
            // Composite primary key
            $table->primary(['student_id', 'course_code', 'semester_id']);
            
            // Foreign key for course_code referencing the courses table
            $table->foreign('course_code')->references('course_code')->on('courses')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('student_course_schedule');
    }
}
