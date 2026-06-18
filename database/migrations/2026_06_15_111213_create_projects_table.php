<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {

            $table->id();

            $table->string('project_name');

            $table->date('start_date');

            $table->date('end_date');

            $table->json('team_members')->nullable();
            /*
            {
                "4":"Project Manager",
                "8":"Developer",
                "10":"Tester"
            }
            */

            $table->enum('status',[
                'Pending',
                'In Progress',
                'Completed'
            ])->default('Pending');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};