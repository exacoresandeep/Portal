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
        Schema::create('evaluation_assign', function (Blueprint $table) {

            $table->id();

            $table->foreignId('evaluation_form_id')
                ->constrained('evaluation_forms')
                ->cascadeOnDelete();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->year('year');

            $table->enum('quarter', [
                'First Quarter',
                'Second Quarter',
                'Third Quarter',
                'Fourth Quarter'
            ]);

            $table->timestamp('submitted_date')->nullable();

            /*
            Example:
            {
                "1": 4,
                "2": 5,
                "3": 3
            }
            question_id => mark
            */
            $table->json('marks')->nullable();

            $table->longText('review')->nullable();

            $table->timestamp('reviewed_at')->nullable();

            $table->enum('status', [
                'pending',
                'completed'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_assign');
    }
};
