<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_phase_assigns', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('training_phase_id');
            $table->unsignedBigInteger('trainee_id');
            $table->unsignedBigInteger('trainer_id');

            $table->enum('status', ['pending', 'completed'])
                ->default('pending');

            $table->enum('hr_status', ['pending', 'completed'])
                ->default('pending');

            $table->longText('hr_remark')->nullable();

            $table->timestamp('assigned_date')->nullable();

            $table->timestamps();

            $table->foreign('training_phase_id')
                ->references('id')
                ->on('training_phases')
                ->onDelete('cascade');

            $table->foreign('trainee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('trainer_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

            $table->unique(
                ['training_phase_id', 'trainee_id'],
                'phase_trainee_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_phase_assigns');
    }
};