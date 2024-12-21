<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemesterGpasTable extends Migration
{
    public function up()
    {
        Schema::create('semester_gpas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('semester_id');
            $table->decimal('gpa', 3, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');

            $table->unique(['student_id', 'semester_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('semester_gpas');
    }
}
