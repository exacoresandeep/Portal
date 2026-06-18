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
        Schema::create('evaluation_schedule', function (Blueprint $table) {

            $table->id();

            $table->foreignId('evaluation_form_id')
                ->constrained('evaluation_forms')
                ->cascadeOnDelete();

            $table->foreignId('department_id')
                ->constrained('departments')
                ->cascadeOnDelete();

            $table->year('year');

            $table->enum('quarter', [
                'First Quarter',
                'Second Quarter',
                'Third Quarter',
                'Fourth Quarter'
            ]);

            $table->date('end_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_schedule');
    }
};
