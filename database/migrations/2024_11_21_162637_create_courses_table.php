<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('course_code')->primary();
            $table->string('name');
            $table->unsignedTinyInteger('credit_hour');
            $table->string('prerequisite')->nullable();
            $table->enum('classification', [ 'URC' , 'CCC', 'DCC' , 'Field Electives', 'Free Electives', 'FYP' , 'IAP',]);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
