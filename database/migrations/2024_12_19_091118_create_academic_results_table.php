<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicResultsTable extends Migration
{
    public function up()
    {
        Schema::create('academic_results', function (Blueprint $table) {
           
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->string('course_code');
            $table->foreign('course_code')->references('course_code')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            $table->string('grade')->nullable();
            $table->decimal('score', 3, 2)->nullable();
            $table->primary(['student_id', 'course_code', 'semester_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_results');
    }
}
