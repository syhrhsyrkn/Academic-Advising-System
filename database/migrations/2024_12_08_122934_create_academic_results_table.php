<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_results', function (Blueprint $table) {
            $table->id();
            $table->string('matric_no');
            $table->string('course_code');
            $table->string('grade', 2)->nullable();
            $table->float('gpa', 3, 2)->nullable();
            $table->float('cgpa', 3, 2)->nullable();
            $table->timestamps();

            $table->foreign('matric_no')->references('matric_no')->on('profiles')->onDelete('cascade');
            $table->foreign('course_code')->references('course_code')->on('courses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_results');
    }
};

