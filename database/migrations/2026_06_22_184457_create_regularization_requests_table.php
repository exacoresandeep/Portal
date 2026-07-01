<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regularization_requests', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('employee_id');

            $table->date('date');

            $table->enum('direction', [
                'in',
                'out'
            ]);

            $table->text('reason');

            $table->timestamp('action_date')
                ->nullable();

            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected'
            ])->default('Pending');

            $table->unsignedBigInteger('action_by')
                ->nullable();

            $table->timestamps();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('action_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'regularization_requests'
        );
    }
};