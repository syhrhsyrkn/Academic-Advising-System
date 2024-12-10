<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary key for each appointment
            $table->string('matric_no')->nullable(); // Foreign key linking to the profile table
            $table->foreign('matric_no')->references('matric_no')->on('profiles')->onDelete('cascade');
            $table->string('advising_reason'); // Reason for the appointment
            $table->string('status')->default('Pending'); // Appointment status
            $table->timestamp('appointment_date')->nullable(); // Scheduled appointment date
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
