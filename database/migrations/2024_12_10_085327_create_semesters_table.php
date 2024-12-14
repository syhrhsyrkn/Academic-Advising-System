<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id(); 
            $table->string('semester_name', 50);
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('semesters');
    }
}
