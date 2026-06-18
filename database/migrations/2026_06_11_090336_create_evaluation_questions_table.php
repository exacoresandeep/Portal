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
        Schema::create('evaluation_questions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('evaluation_form_id')
                ->constrained('evaluation_forms')
                ->cascadeOnDelete();

            $table->longText('question');

            $table->integer('marks')->default(0);

            // ["Communication","Team Work","Leadership"]
            $table->json('subpoints')->nullable();

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_questions');
    }
};
