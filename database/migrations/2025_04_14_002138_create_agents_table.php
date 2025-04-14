<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key (bigint)
            $table->string('name'); // Agent's full name
            $table->string('email')->unique(); // Agent's email address (must be unique)
            $table->string('password'); // Hashed password for authentication
            $table->string('phone_number')->nullable(); // Agent's phone number (optional)
            $table->text('address')->nullable(); // Agent's address (optional, can be longer text)
            $table->string('profile_picture')->nullable(); // New column for profile picture path/filename
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents'); // Drops the 'agents' table if the migration is rolled back
    }
}
