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
        Schema::create('task_updates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('task_id')
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('employee_id');

            $table->enum('status',[
                // 'Not Started',
                'Pending',
                'In Progress',
                'On Hold',
                'Completed'
            ]);

            $table->integer('progress');

            $table->integer('hours_worked');

            $table->integer('remaining_hours');

            $table->string('challenge')->nullable();

            $table->text('work_summary')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_updates');
    }
};
