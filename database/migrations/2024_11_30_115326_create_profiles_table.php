<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
{
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('full_name');
        $table->string('email'); 
        $table->string('contact_number');
        $table->string('kulliyyah');
        $table->string('department');
        $table->string('specialisation')->nullable(); // For students only
        $table->string('matric_no')->unique()->nullable();  // For students only
        $table->integer('year')->nullable(); // For students only
        $table->integer('semester')->nullable(); // For students only
        $table->string('staff_id')->nullable(); // For advisor/admin only
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
