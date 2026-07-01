<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_calendars', function (Blueprint $table) {

            $table->id();

            $table->year('year');

            $table->unsignedBigInteger('project_id');

            $table->json('holidays')->nullable();
            /*
            [
                {
                    "date":"2026-01-01",
                    "description":"New Year"
                },
                {
                    "date":"2026-08-15",
                    "description":"Independence Day"
                }
            ]
            */

            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_calendars');
    }
};