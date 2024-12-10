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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('full_name');
            $table->string('contact_no');
            $table->string('matric_no')->unique();
            $table->string('kulliyyah');
            $table->string('department');
            $table->string('specialisation')->nullable(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}

