<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->date('dob')->nullable();
            $table->string('designation')->nullable();

            $table->string('contact_no')->nullable();
            $table->string('alt_contact_no')->nullable();

            $table->enum('type', ['admin', 'employee'])->default('employee');

            $table->string('pan_no')->nullable();
            $table->string('aadhar_no')->nullable();

            $table->boolean('status')->default(1); // 1 = active
            $table->boolean('data_status')->default(1);

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
