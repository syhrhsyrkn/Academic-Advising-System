<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staff_id'); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('full_name'); 
            $table->string('contact_no'); 
            $table->string('kulliyyah'); 
            $table->string('department'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
