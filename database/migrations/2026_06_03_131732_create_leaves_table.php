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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');

            $table->date('from_date');
            $table->date('to_date');

            $table->enum('leave_type', [
                'Sick',
                'Casual',
                'Earned',
                'WFH',
                'Maternity',
                'LOP'
            ]);

            $table->text('reason')->nullable();
            $table->string('attachment')->nullable();

            $table->enum('status', [
                'Approved',
                'Rejected',
                'Pending'
            ])->default('Pending');

            $table->dateTime('action_date')->nullable();
            $table->unsignedBigInteger('action_by')->nullable();

            $table->timestamps();

            $table->index('employee_id');
            $table->index('status');

            // Uncomment if employees are stored in users table
            // $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('action_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};