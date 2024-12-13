<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('advising_reason');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled']) 
                  ->default('pending');  
            $table->dateTime('appointment_date'); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
