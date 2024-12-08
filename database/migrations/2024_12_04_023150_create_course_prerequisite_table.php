<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prerequisites', function (Blueprint $table) {
            $table->id();
            $table->string('course_code'); 
            $table->string('prerequisite_code');

            $table->foreign('course_code')->references('course_code')->on('courses')->onDelete('cascade');
            $table->foreign('prerequisite_code')->references('course_code')->on('courses')->onDelete('cascade');

            $table->unique(['course_code', 'prerequisite_code']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prerequisites');
    }
};
