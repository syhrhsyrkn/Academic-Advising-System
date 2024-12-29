<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('matric_no')->unique()->nullable();
            $table->string('kulliyyah')->nullable();
            $table->string('department')->nullable();
            $table->string('specialisation')->nullable();
            $table->unsignedTinyInteger('year')->nullable();
            $table->unsignedTinyInteger('semester')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}