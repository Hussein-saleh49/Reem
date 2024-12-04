<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->unsignedBigInteger('appointment_id')->nullable(); // Foreign key to appointments table
            $table->string('medication_name'); // Medication name
            $table->date('reminder_date'); // Date of the reminder
            $table->time('reminder_time'); // Time of the reminder
            $table->enum('am_pm', ['AM', 'PM']); // AM or PM
            $table->enum('repeat', ['none', 'daily', 'weekly', 'monthly'])->default('none'); // Repeat frequency
            $table->string('sound')->default('default'); // Alarm sound
            $table->string('label')->nullable(); // Optional label
            $table->integer('ring_duration')->default(30); // Ring duration in seconds
            $table->integer('snooze_duration')->default(5); // Snooze duration in minutes
            $table->timestamps(); // Created at and updated at

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}
