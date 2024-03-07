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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20)->unique();
            $table->string('user_name', 50);
            $table->string('name_prefix', 10)->nullable();
            $table->string('first_name', 50);
            $table->string('middle_initial', 1)->nullable();
            $table->string('last_name', 50);
            $table->enum('gender', ['F', 'M']);
            $table->string('email', 100)->unique();
            $table->date('date_of_birth');
            $table->string('time_of_birth')->nullable();
            $table->float('age_in_years', 5, 2);
            $table->date('date_of_joining');
            $table->float('age_in_company', 5, 2);
            $table->string('phone_number', 20);
            $table->string('place_name', 100);
            $table->string('county', 50);
            $table->string('city', 50);
            $table->string('zip', 10);
            $table->string('region', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
