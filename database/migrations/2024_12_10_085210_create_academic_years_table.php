<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicYearsTable extends Migration
{
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id(); 
            $table->string('year_name', 50); 
            $table->year('start_year'); 
            $table->year('end_year');
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_years');
    }
}
